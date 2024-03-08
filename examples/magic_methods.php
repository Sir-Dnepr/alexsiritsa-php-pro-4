<?php
require_once __DIR__ . '/autoload.php';

use App\HomeWork03\QueryConstruct;
use App\HomeWork03\Customer;
use App\HomeWork03\CustomerAddress;
use App\HomeWork03\ProductAttributes;

// __toString()
$magicMethods = new QueryConstruct(
    ['firstname', 'email'],
    'customer',
    [['id', '>', 4], ['age', '=', 25]]
);

echo (string)$magicMethods . PHP_EOL;

// __clone()
$customerAddress = new CustomerAddress('Dnipro');
$customer = new Customer('Alex', $customerAddress);
echo $customer->getInfo() . PHP_EOL;

$customerSecond = clone($customer);
$customerAddress->setCity('Nikopol');

echo $customer->getInfo() . PHP_EOL;
echo $customerSecond->getInfo() . PHP_EOL;

// __get, __set()
$productAttributes = new ProductAttributes();
$productAttributes->name = 'Alex';
$productAttributes->credit = '10993';
$productAttributes->lastname = 'Syrytsia';

echo $productAttributes->name . PHP_EOL;
echo $productAttributes->credit . PHP_EOL;
echo $productAttributes->lastname . PHP_EOL;

$attributes = $productAttributes->getAttributes();

var_dump($attributes);exit();

exit;
