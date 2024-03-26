<?php

namespace App\Services\Helpers;

class MaskingData implements MaskingDataInterface
{
    protected string $dictionary = '0123456789abcdefghijklmnopqrstuvwxyz';
    protected string $mask = '5pbrmwi9ql28ocn16zf4t7hajxy0kdsvueg3';

    protected ShiftArrayInterface $shiftArray;

    public function __construct(ShiftArrayInterface $shiftArray)
    {
        $this->shiftArray = $shiftArray;
    }

    public function mask(string $data): string
    {
        $sourceData = str_split($data);

        $dictionary = str_split($this->dictionary);
        $mask = str_split($this->mask);
        $shift = rand(0, 9);

        $maskWithShift = $this->shiftArray->execute($mask, $shift);

        $maskedData = array_map(function ($char) use ($dictionary, $maskWithShift) {
            $index = array_search($char, $dictionary);
            return $maskWithShift[$index];
        }, $sourceData);

        return $shift . implode($maskedData);
    }

    public function unMask(string $data): string
    {
        $maskedData = str_split($data);

        $dictionary = str_split($this->dictionary);
        $mask = str_split($this->mask);
        $maskShiftPrefix = array_splice($maskedData, 0, 1);
        $shift = (int)$maskShiftPrefix[0];

        $maskWithShift = $this->shiftArray->execute($mask, $shift);

        $sourceData = array_map(function ($char) use ($maskWithShift, $dictionary) {
            $index = array_search($char, $maskWithShift);
            return $dictionary[$index];
        }, $maskedData);

        return implode($sourceData);
    }
}
