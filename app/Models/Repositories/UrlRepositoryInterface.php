<?php

namespace App\Models\Repositories;

interface UrlRepositoryInterface
{
    public function getUrlsCountByUrl(string $url): int;

    public function getUrlById(float $id): string;

    public function insertUrlAndGetId(string $url): float;
}
