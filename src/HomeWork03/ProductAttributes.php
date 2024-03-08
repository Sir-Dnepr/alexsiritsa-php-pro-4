<?php
declare(strict_types=1);

namespace App\HomeWork03;

class ProductAttributes
{
    protected string $credit;
    protected string $name;
    protected string $lastname;

    protected array $availableCustomAttributes = [
        'credit',
        'name'
    ];

    public function getAttributes(): array
    {
        return $this->availableCustomAttributes;
    }

    public function __get(string $attrName): ?string
    {
        return in_array($attrName, $this->availableCustomAttributes)
            ? $this->$attrName
            : null;
    }

    public function __set(string $attrName, mixed $attrValue): void
    {
        if (in_array($attrName, $this->availableCustomAttributes)) {
            $this->$attrName = $attrValue;
        }
    }
}
