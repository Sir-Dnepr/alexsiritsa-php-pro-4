<?php
declare(strict_types=1);

namespace App\HomeWork04\UrlShortener\Exceptions;

use Exception;

class IncorrectResponseCodeException extends Exception
{
    protected $message = 'Response code is not correct';
}
