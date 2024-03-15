<?php
declare(strict_types=1);

namespace App\HomeWork04\UrlShortener\Exceptions;

use Exception;

class EntityNotExistsException extends Exception
{
    protected $message = 'Entity not exists';
}
