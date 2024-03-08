<?php
declare(strict_types=1);

namespace App\HomeWork03;

class CustomerAddress
{
    public function __construct(protected string $city)
    {
    }

    public function setCity(string $city): void
    {
        $this->city = $city;
    }

    public function getCity(): string
    {
        return  'My city - ' . $this->city;
    }
}
