<?php
declare(strict_types=1);

namespace App\HomeWork04\UrlShortener\Models;

use App\HomeWork04\UrlShortener\Api\ICodeRepository;
use App\HomeWork04\UrlShortener\Exceptions\EntityNotExistsException;
use App\HomeWork04\UrlShortener\ValueObjects\ShorterEntity;
use App\HomeWork04\UrlShortener\Api\ValueObjects\IShorterEntity;

class FileRepository implements ICodeRepository
{
    protected array $db = [];

    public function __construct(protected string $fileDbFullPath)
    {
        $this->getDbFromStorage();
    }

    public function saveEntity(IShorterEntity $urlCodeEntity): void
    {
        $this->db[] = [
            IShorterEntity::FIELD_CODE => $urlCodeEntity->getCode(),
            IShorterEntity::FIELD_URL => $urlCodeEntity->getUrl(),
        ];
    }

    public function isCodeExists(string $code): bool
    {
        return in_array($code, array_column($this->db, IShorterEntity::FIELD_CODE));
    }

    public function getByFieldName(string $fieldName, string $searchValue): IShorterEntity
    {
        $searchResult = [];

        foreach ($this->db as $entity) {
            if (isset($entity[$fieldName]) && $entity[$fieldName] === $searchValue) {
                $searchResult = $entity;
                break;
            }
        }

        if (!$searchResult) {
            throw new EntityNotExistsException();
        }

        return new ShorterEntity(
            $searchResult[IShorterEntity::FIELD_CODE],
            $searchResult[IShorterEntity::FIELD_URL],
        );
    }

    protected function getDbFromStorage(): void
    {
        if (file_exists($this->fileDbFullPath)) {
            $dbContent = file_get_contents($this->fileDbFullPath);
            $this->db = (array)json_decode($dbContent, true);
        }
    }

    protected function writeFile(string $content): void
    {
        $file = fopen($this->fileDbFullPath, 'w+');
        fwrite($file, $content);
        fclose($file);
    }

    public function __destruct()
    {
        $this->writeFile(json_encode($this->db));
    }
}
