<?php
declare(strict_types=1);

namespace App\HomeWork04\UrlShortener\ValueObjects;

use App\HomeWork04\UrlShortener\Api\ValueObjects\IShorterEntity;

class ShorterEntity implements IShorterEntity
{
    public function __construct(protected string $code, protected string $url)
    {
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function getUrl(): string
    {
        return $this->url;
    }
}
