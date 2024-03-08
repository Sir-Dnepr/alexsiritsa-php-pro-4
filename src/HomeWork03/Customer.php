<?php
declare(strict_types=1);

namespace App\HomeWork03;

class Customer
{
    public function __construct(
        protected string $customerName,
        protected CustomerAddress $customerAddress,
    ) {
    }

    public function getInfo(): string
    {
        return $this->customerName . ' ' . $this->customerAddress->getCity();
    }

    public function __clone() {
        $this->customerAddress = clone $this->customerAddress;
    }
}
