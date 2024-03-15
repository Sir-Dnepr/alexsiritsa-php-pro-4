<?php

namespace App\HomeWork04\UrlShortener\Api\ValueObjects;

interface IShorterEntity
{
    public const FIELD_CODE = 'code';
    public const FIELD_URL = 'url';

    /**
     * @return string
     */
    public function getCode(): string;

    /**
     * @return string
     */
    public function getUrl(): string;
}
