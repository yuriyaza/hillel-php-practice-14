<?php

namespace App\Services\Helpers;

class ShiftArray implements ShiftArrayInterface
{
    public function execute(array $array, int $shift): array
    {
        $offset = $shift % count($array);
        $splice = array_splice($array, $offset);

        return array_merge($splice, $array);
    }
}
