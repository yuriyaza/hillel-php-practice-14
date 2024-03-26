<?php

namespace App\Models\Repositories;

use Illuminate\Support\Facades\DB;

class UrlRepository implements UrlRepositoryInterface
{
    public function getUrlsCountByUrl(string $url): int
    {
        try {
            return DB::table('urls')
                ->where('url', '=', $url)
                ->count('id');

        } catch (\Exception) {
            throw new UrlRepositoryException('Database connection error', 500);
        }
    }

    public function getUrlById(float $id): string
    {
        try {
            $data = DB::table('urls')
                ->find($id);

            if (!$data) {
                throw new UrlRepositoryException('Data is not found', 404);
            }

            return $data->url;

        } catch (UrlRepositoryException $repositoryException) {
            throw $repositoryException;

        } catch (\Exception $exception) {
            throw new UrlRepositoryException('Database connection error', 500);
        }
    }

    public function insertUrlAndGetId(string $url): float
    {
        try {
            return DB::table('urls')
                ->insertGetId(['url' => $url]);

        } catch (\Exception) {
            throw new UrlRepositoryException('Database connection error', 500);
        }
    }
}
