<?php

namespace App\Models\Repositories;

use Illuminate\Support\Facades\DB;
use MongoDB\BSON\UTCDateTime;
use MongoDB\Operation\FindOneAndUpdate;

class MongoDbRepository implements MongoDbRepositoryInterface
{
    public function getUrlById(float $id): string
    {
        try {
            $data = DB::collection('urls')
                ->find($id);

            if (!$data) {
                throw new MongoDbRepositoryException('Data is not found', 404);
            }

            return $data['url'];

        } catch (MongoDbRepositoryException $repositoryException) {
            throw $repositoryException;

        } catch (\Exception) {
            throw new MongoDbRepositoryException('Database error', 500);
        }
    }

    public function insertUrlAndReturnId(string $url): float
    {
        try {
            return DB::collection('urls')
                ->insertGetId([
                    '_id' => $this->incrementUrlIdCounter(),
                    'url' => $url,
                    'createdAt' => new UTCDateTime(time() * 1000),
                    'updatedAt' => new UTCDateTime(time() * 1000),
                ]);

        } catch (\Exception) {
            throw new MongoDbRepositoryException('Database error', 500);
        }
    }

    public function incrementUrlIdCounter()
    {
        $data = DB::getCollection('counters')
            ->findOneAndUpdate(
                ['counter_name' => 'id'],
                ['$inc' => ['counter_sequence' => 1]],
                ['new' => true, 'upsert' => true, 'returnDocument' => FindOneAndUpdate::RETURN_DOCUMENT_AFTER]
            );

        return $data->counter_sequence;
    }
}
