<?php
declare(strict_types=1);

namespace App\HomeWork04\UrlShortener\Exceptions;

use Exception;

class UniqueCodeGenerationException extends Exception
{
    protected $message = 'A unique code cannot be generated';
}
