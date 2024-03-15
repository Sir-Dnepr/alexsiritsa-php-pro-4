<?php
declare(strict_types=1);

namespace App\HomeWork04\UrlShortener\Services;

use App\HomeWork04\UrlShortener\Api\ICodeRepository;
use App\HomeWork04\UrlShortener\Api\IUrlDecoder;
use App\HomeWork04\UrlShortener\Api\IUrlEncoder;
use App\HomeWork04\UrlShortener\Api\IUrlValidator;
use App\HomeWork04\UrlShortener\Api\ValueObjects\IShorterEntity;
use App\HomeWork04\UrlShortener\ValueObjects\ShorterEntity;
use App\HomeWork04\UrlShortener\Exceptions\IncorrectResponseCodeException;
use App\HomeWork04\UrlShortener\Exceptions\EntityNotExistsException;
use App\HomeWork04\UrlShortener\Exceptions\UniqueCodeGenerationException;
use InvalidArgumentException;

class UrlConverter implements IUrlEncoder, IUrlDecoder
{
    public const CODE_LENGTH = 6;
    public const CODE_CHAIRS = '0123456789abcdefghijklmnopqrstuvwxyz';
    public const MAXIMUM_NUMBER_CODE_GENERATION_ATTEMPTS = 5;

    protected int $currentNumberCodeGenerationAttempts = 0;

    public function __construct(
        protected ICodeRepository $repository,
        protected IUrlValidator $validator,
        protected int $codeLength = self::CODE_LENGTH
    )
    {
    }

    /**
     * @param string $url
     *
     * @return string
     *
     * @throws IncorrectResponseCodeException
     * @throws InvalidArgumentException
     */
    public function encode(string $url): string
    {
        $this->validateUrl($url);

        try {
            $entity = $this->repository->getByFieldName(IShorterEntity::FIELD_URL, $url);
            $code = $entity->getCode();
        } catch (EntityNotExistsException) {
            $code = $this->generateCode($url);
            $this->saveCode($url, $code);
        }

        return $code;
    }

    /**
     * @param string $code
     *
     * @return string
     *
     * @throws InvalidArgumentException
     */
    public function decode(string $code): string
    {
        try {
            $entity = $this->repository->getByFieldName(IShorterEntity::FIELD_CODE, $code);
        } catch (EntityNotExistsException $e) {
            throw new InvalidArgumentException(
                $e->getMessage(),
                $e->getCode(),
                $e->getPrevious()
            );
        }

        return $entity->getUrl();
    }

    /**
     * @param string $url
     * @return string
     *
     * @throws UniqueCodeGenerationException
     */
    protected function generateCode(string $url): string
    {
        $code = $this->generateUniqueCode();

        try {
            $this->repository->getByFieldName(IShorterEntity::FIELD_CODE, $code);

            if (++$this->currentNumberCodeGenerationAttempts > self::MAXIMUM_NUMBER_CODE_GENERATION_ATTEMPTS) {
                throw new UniqueCodeGenerationException();
            }

            $this->generateCode($url);
        } catch (EntityNotExistsException) {
            return $code;
        }
    }

    protected function saveCode(string $url, string $code): void
    {
        $this->repository->saveEntity(new ShorterEntity($code, $url));
    }

    protected function validateUrl(string $url): void
    {
        $this->validator->validateUrl($url);
        $this->validator->checkRealUrl($url);
    }

    protected function generateUniqueCode(): string
    {
        $code = preg_replace('/[^' . static::CODE_CHAIRS. ']+/', '', uniqid('', true));

        return substr(str_shuffle($code), 0, $this->codeLength);
    }
}
