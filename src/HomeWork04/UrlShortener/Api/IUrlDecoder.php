<?php

namespace App\HomeWork04\UrlShortener\Api;

interface IUrlDecoder
{
    /**
     * @param string $code
     *
     * @throws \InvalidArgumentException
     *
     * @return string
     */
    public function decode(string $code): string;
}
