<?php

namespace App\Services;

interface UrlEncoderInterface
{
    public function convertToShortUrl(string $hostName, string $originalUrl): string;

    public function convertToOriginalUrl(string $shortUrl);
}
