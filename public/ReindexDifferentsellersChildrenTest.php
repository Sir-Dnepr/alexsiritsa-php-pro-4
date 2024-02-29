<?php
declare(strict_types=1);

use Lib\Netflix\Core\Service\EventProcessor\EventData;
use Lib\Netflix\Core\Service\EventProcessor\Observers\AdminhtmlArea\ReindexSupersellersChildren;
use Lib\Netflix\CronIndexer\Api\HelperInterfaceFactory;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\MockObject\MockObject;
use Netflix\Catalog\Model\Product;
use Netflix\TestFramework\Test\Integration\Framework\Assert;
use Netflix\CronIndexerApi\Model\Data\Category\Product\Price\QueueInterface;
use Netflix\SuperSellersApi\Model\Product\Type\SuperSellersInterface;
use Lib\Netflix\Catalog\Api\CheckIsSuperSellersInterface;
use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;

/**
 * @see \Lib\Netflix\Core\Service\EventProcessor\Observers\AdminhtmlArea\ReindexSupersellersChildren;
 */
class ReindexSupersellersChildrenTest extends TestCase
{
    /** @var ReindexSupersellersChildren */
    private $observer;

    /** @var PHPUnit_Framework_MockObject_MockObject|Product */
    private $superSellersProductMock;

    /** @var HelperInterfaceFactory */
    private $helper;

    /** @var CheckIsSuperSellersInterface */
    private $checkIsSuperSellers;

    /**
     * @inheritDoc
     */
    protected function setUp()
    {
        parent::setUp();

        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $this->helper = $objectManager->get(HelperInterfaceFactory::class);
        $this->checkIsSuperSellers = $objectManager->get(CheckIsSuperSellersInterface::class);
    }

    /**
     * Test add to reindex queue success
     *
     * @dataProvider dataProvider
     *
     * @param array $params
     *
     * @return void
     */
    public function testAddToReindexQueue(array $params): void
    {
        $this->mockProducts($params['child_ids'], $params['product_type_id']);
        $this->mockObserver();

        $eventDataMock = $this->createPartialMock(EventData::class, ['getProduct']);
        $eventDataMock->expects($this->any())
            ->method('getProduct')
            ->willReturn($this->superSellersProductMock);

        $this->observer->execute($eventDataMock);

        Assert::assertTableData(
            $this,
            QueueInterface::MAIN_TABLE,
            $params['expectation_fields'],
            $params['expectation_values']
        );
    }

    /**
     * Mock Products
     *
     * @param array $childIds
     * @param string $typeId
     *
     * @return void
     */
    private function mockProducts(array $childIds = [], string $typeId = ''): void
    {
        $superSellersTypeMock = $this->createSuperSellersTypeMock();
        $this->superSellersProductMock = $this->createPartialMock(Product::class, ['getTypeInstance', 'getTypeId']);

        $this->superSellersProductMock
            ->expects($this->any())
            ->method('getTypeInstance')
            ->willReturn($superSellersTypeMock);

        $this->superSellersProductMock
            ->expects($this->any())
            ->method('getTypeId')
            ->willReturn($typeId);

        $superSellersTypeMock
            ->expects($this->any())
            ->method('getUsedProducts')
            ->willReturn($this->getChildProductsMock($childIds));
    }

    /**
     * Get child products Mock
     *
     * @param array $childrenItemIds
     *
     * @return array
     */
    private function getChildProductsMock(array $childrenItemIds): array
    {
        $childProducts = [];

        foreach ($childrenItemIds as $id) {
            $variationProductMock = $this->createPartialMock(Product::class, ['getId']);
            $variationProductMock->expects($this->any())
                ->method('getId')
                ->willReturn($id);

            $childProducts[] = $variationProductMock;
        }

        return $childProducts;
    }

    /**
     * Exclusion test data provider.
     *
     * @return array[][]
     */
    public function dataProvider(): array
    {
        return [
            'one child element for reindex' => [
                'params' => [
                    'child_ids' => [2],
                    'product_type_id' => 'supersellers',
                    'expectation_fields' => ['entity', 'product_ids', 'type'],
                    'expectation_values' => [
                        ['entity' => 'catalog_product', 'product_ids' => '2', 'type' => 'mass_action']
                    ]
                ]
            ],
            'without child elements for reindex' => [
                'params' => [
                    'child_ids' => [],
                    'product_type_id' => 'supersellers',
                    'expectation_fields' => ['entity', 'product_ids', 'type'],
                    'expectation_values' => []
                ]
            ],
            'three child elements for reindex' => [
                'params' => [
                    'child_ids' => [3,6,9],
                    'product_type_id' => 'supersellers',
                    'expectation_fields' => ['entity', 'product_ids', 'type'],
                    'expectation_values' => [
                        ['entity' => 'catalog_product', 'product_ids' => '3,6,9', 'type' => 'mass_action']
                    ]
                ]
            ],
            'configurable product type' => [
                'params' => [
                    'child_ids' => [2],
                    'product_type_id' => 'configurable',
                    'expectation_fields' => ['entity', 'product_ids', 'type'],
                    'expectation_values' => []
                ]
            ],
        ];
    }

    /**
     * Create super sellers type mock
     *
     * @return MockObject
     */
    private function createSuperSellersTypeMock(): MockObject
    {
        return $this->getMockBuilder(SuperSellersInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
    }

    /**
     * Mock Observer
     *
     * @return void
     */
    private function mockObserver(): void
    {
        $this->observer = (new ObjectManager($this))->getObject(
            ReindexSupersellersChildren::class,
            [
                'checkIsSuperSellers' => $this->checkIsSuperSellers,
                'helper' => $this->helper->create()
            ]
        );
    }
}
