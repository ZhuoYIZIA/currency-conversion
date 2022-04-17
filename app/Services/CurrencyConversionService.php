<?php

namespace App\Services;

use App\Exceptions\ConversionExcaption;

class CurrencyConversionService
{
    /**
     * 貨幣轉換 exception
     */
    private $conversionExcaption;

    public function __construct(ConversionExcaption $conversionExcaption)
    {
        $this->conversionExcaption = $conversionExcaption;
    }

    /**
     * 轉換匯率
     * 
     * @param  float  $amount  兌換金額
     * @param  float  $rate    匯率
     * 
     * @return string  兌換後金額
     */
    public function convert(float $amount, float $ratio): string
    {
        return $this->format($amount * $ratio);
    }

    /**
     * 轉換成千分位格式
     * 
     * @param  float  $amount 金額
     * 
     * @return string 轉換後的格式
     */
    private function format(float $amount): string
    {
        return number_format($amount, 2);
    }
}