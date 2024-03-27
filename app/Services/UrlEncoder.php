<?php

namespace App\Services;

use App\Models\Repositories\MongoDbRepositoryException;
use App\Models\Repositories\MongoDbRepositoryInterface;
use App\Services\Helpers\MaskingDataInterface;

class UrlEncoder implements UrlEncoderInterface
{
    protected const INITIAL_DATA = 10000000;

    protected MongoDbRepositoryInterface $urlRepository;
    protected MaskingDataInterface $maskingData;

    public function __construct(MongoDbRepositoryInterface $urlRepository, MaskingDataInterface $maskingData)
    {
        try {
            $this->urlRepository = $urlRepository;
            $this->maskingData = $maskingData;

        } catch (MongoDbRepositoryException $repositoryException) {
            // Прокидуємо MongoDbRepositoryException в Controller
            throw new UrlEncoderExeption($repositoryException->getMessage(), $repositoryException->getCode());
        }
    }

    public function convertToShortUrl(string $hostName, string $originalUrl): string
    {
        try {
            $id = $this->urlRepository->insertUrlAndReturnId($originalUrl);
            $urlData = self::INITIAL_DATA + $id;
            $shortUrl = base_convert($urlData, 10, 36);
            $maskedShortUrl = $this->maskingData->mask($shortUrl);

            return 'http://' . $hostName . '/' . $maskedShortUrl;

        } catch (MongoDbRepositoryException $repositoryException) {
            // Прокидуємо MongoDbRepositoryException в Controller
            throw new UrlEncoderExeption($repositoryException->getMessage(), $repositoryException->getCode());
        }
    }

    public function convertToOriginalUrl(string $shortUrl): string
    {
        try {
            $unmaskedShortUrl = $this->maskingData->unMask($shortUrl);
            $urlData = base_convert($unmaskedShortUrl, 36, 10);
            $id = $urlData - self::INITIAL_DATA;
            $originalUrl = $this->urlRepository->getUrlById($id);

            if (!str_starts_with($originalUrl, 'http')) {
                $originalUrl = 'http://' . $originalUrl;
            }

            return $originalUrl;

        } catch (MongoDbRepositoryException $repositoryException) {
            // Прокидуємо MongoDbRepositoryException в Controller
            throw new UrlEncoderExeption($repositoryException->getMessage(), $repositoryException->getCode());
        }
    }
}
