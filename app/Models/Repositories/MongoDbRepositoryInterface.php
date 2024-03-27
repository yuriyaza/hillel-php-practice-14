<?php

namespace App\Models\Repositories;

interface MongoDbRepositoryInterface
{
    public function getUrlById(float $id): string;

    public function insertUrlAndReturnId(string $url): float;
}
