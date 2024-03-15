<?php

namespace App\HomeWork04\UrlShortener\Api;

use App\HomeWork04\UrlShortener\Exceptions\IncorrectResponseCodeException;
use InvalidArgumentException;

interface IUrlValidator
{
    /**
     * @param string $url
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public function validateUrl(string $url): void;

    /**
     * @param string $url
     *
     * @throws IncorrectResponseCodeException
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public function checkRealUrl(string $url): void;
}
