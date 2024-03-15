<?php

namespace App\HomeWork04\UrlShortener\Api;

use App\HomeWork04\UrlShortener\Exceptions\IncorrectResponseCodeException;
use InvalidArgumentException;

interface IUrlEncoder
{
    /**
     * @param string $url
     *
     * @return string
     *
     * @throws IncorrectResponseCodeException
     * @throws InvalidArgumentException
     */
    public function encode(string $url): string;
}
