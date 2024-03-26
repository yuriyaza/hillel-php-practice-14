<?php

namespace App\Providers;

use App\Models\Repositories\UrlRepository;
use App\Models\Repositories\UrlRepositoryInterface;
use App\Services\Helpers\ShiftArray;
use App\Services\Helpers\ShiftArrayInterface;
use App\Services\Helpers\MaskingData;
use App\Services\Helpers\MaskingDataInterface;
use App\Services\UrlEncoder;
use App\Services\UrlEncoderInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(UrlRepositoryInterface::class, UrlRepository::class);
        $this->app->bind(UrlEncoderInterface::class, UrlEncoder::class);
        $this->app->bind(MaskingDataInterface::class, MaskingData::class);
        $this->app->bind(ShiftArrayInterface::class, ShiftArray::class);
    }

    public function boot(): void
    {

    }
}
