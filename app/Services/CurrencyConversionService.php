<?php

namespace App\Services;

use App\Repositories\ExchangeRateRepository;

class CurrencyConversionService
{
    private $exchangeRateRepo;

    public function __construct(ExchangeRateRepository $exchangeRateRepo)
    {
        $this->exchangeRateRepo = $exchangeRateRepo;
    }

    /**
     * 轉換匯率
     * 
     * @param  string  $from    
     * @param  string  $to      兌換貨幣
     * @param  float   $amount  兌換金額
     * 
     * @return string  兌換後金額
     */
    public function convert(string $from, string $to, float $amount): string
    {
        $rate = $this->exchangeRateRepo->getRate();
        $ratio = $rate->$from->$to;

        return $this->format($amount * $ratio);
    }

    /**
     * 轉換成千分位格式
     * 
     * @param  float  $amount 金額
     * 
     * @return string 轉換後的格式
     */
    public function format(float $amount): string
    {
        return number_format($amount, 2);
    }
}