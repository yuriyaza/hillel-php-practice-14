<?php

namespace App\Services\Helpers;

interface MaskingDataInterface
{
    public function mask(string $data): string;

    public function unMask(string $data): string;
}
