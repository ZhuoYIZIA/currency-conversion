<?php

namespace App\Services;

use App\Repositories\ExchangeRateRepository;
use App\Exceptions\ConversionExcaption;

class CurrencyConversionService
{
    private $exchangeRateRepo;
    private $conversionExcaption;

    public function __construct(
        ExchangeRateRepository $exchangeRateRepo,
        ConversionExcaption $conversionExcaption
    ) {
        $this->exchangeRateRepo    = $exchangeRateRepo;
        $this->conversionExcaption = $conversionExcaption;
    }

    /**
     * 轉換匯率
     * 
     * @param  string  $from    來源貨幣
     * @param  string  $to      兌換貨幣
     * @param  float   $amount  兌換金額
     * 
     * @return string  兌換後金額
     */
    public function convert(string $from, string $to, float $amount): string
    {
        $rate = $this->exchangeRateRepo->getRate();
        if ( ! isset($rate->$from)) {
            throw $this->conversionExcaption->error('查無此貨幣', 400, false);
        }
        if ( ! isset($rate->$from->$to)) {
            throw $this->conversionExcaption->error('查無此貨幣', 400, false);
        }
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