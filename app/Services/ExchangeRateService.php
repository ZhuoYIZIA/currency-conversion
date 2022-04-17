<?php

namespace App\Services;

use App\Exceptions\ConversionExcaption;

class ExchangeRateService
{
    private $conversionExcaption;

    public function __construct(ConversionExcaption $conversionExcaption)
    {
        $this->conversionExcaption = $conversionExcaption;
    }

    /**
     * 取得該幣別匯率
     * 
     * @return float 匯率
     */
    public function getRatio(string $from, string $to): float
    {
        $ratio = $this->ratio();

        if ( ! isset($ratio->$from)) {
            throw $this->conversionExcaption->error('查無此貨幣', 400, false);
        }
        if ( ! isset($ratio->$from->$to)) {
            throw $this->conversionExcaption->error('查無此貨幣', 400, false);
        }
        return $ratio->$from->$to;
    }

    /**
     * 匯率
     * 
     * @return object 各幣別匯率
     */
    private function ratio(): object
    {
        $ratioObject = json_decode('{"currencies": {"TWD": {"TWD": 1,"JPY": 3.669,"USD": 0.03281},"JPY": {"TWD": 0.26956,"JPY": 1,"USD": 0.00885},"USD": {"TWD": 30.444,"JPY": 111.801,"USD": 1}}}');
        return $ratioObject->currencies;
    }
}