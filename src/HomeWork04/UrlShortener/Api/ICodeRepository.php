<?php

namespace App\HomeWork04\UrlShortener\Api;

use App\HomeWork04\UrlShortener\Api\ValueObjects\IShorterEntity;
use App\HomeWork04\UrlShortener\ValueObjects\ShorterEntity;
use App\HomeWork04\UrlShortener\Exceptions\EntityNotExistsException;

interface ICodeRepository
{
    /**
     * @param ShorterEntity $urlCodeEntity
     *
     * @return void
     */
    public function saveEntity(ShorterEntity $urlCodeEntity): void;

    /**
     * @param string $code
     *
     * @return bool
     */
    public function isCodeExists(string $code): bool;

    /**
     * @param string $fieldName
     * @param string $searchValue
     *
     * @return IShorterEntity
     *
     * @throws EntityNotExistsException
     */
    public function getByFieldName(string $fieldName, string $searchValue): IShorterEntity;
}
