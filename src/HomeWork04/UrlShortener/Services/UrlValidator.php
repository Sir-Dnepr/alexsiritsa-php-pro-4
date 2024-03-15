<?php
declare(strict_types=1);

namespace App\HomeWork04\UrlShortener\Services;

use App\HomeWork04\UrlShortener\Api\IUrlValidator;
use App\HomeWork04\UrlShortener\Exceptions\IncorrectResponseCodeException;
use InvalidArgumentException;

class UrlValidator implements IUrlValidator
{
    protected const ALLOWED_REQUEST_CODES = [
        200, 201, 301, 302
    ];

    public function validateUrl(string $url): void
    {
        if (filter_var($url, FILTER_VALIDATE_URL) === false) {
            throw new InvalidArgumentException('Url is not valid');
        }
    }

    /**
     * @param string $url
     * @return void
     * @throws IncorrectResponseCodeException
     */
    public function checkRealUrl(string $url): void
    {
        $curlHandle = curl_init($url);
        curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curlHandle, CURLOPT_HEADER, true);
        curl_exec($curlHandle);

        if (curl_errno($curlHandle)) {
            throw new InvalidArgumentException(curl_error($curlHandle));
        }

        $httpResponseCode = curl_getinfo($curlHandle, CURLINFO_HTTP_CODE);
        curl_close($curlHandle);

        if (empty($httpResponseCode) || !in_array($httpResponseCode, self::ALLOWED_REQUEST_CODES)) {
            throw new IncorrectResponseCodeException(
                empty($httpResponseCode)
                    ? 'HTTP code is empty'
                    : 'Response code is ' . $httpResponseCode .
                        '. Code must by one of ' . implode(',', self::ALLOWED_REQUEST_CODES)
            );
        }
    }
}
