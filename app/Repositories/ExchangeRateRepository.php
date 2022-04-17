<?php

namespace App\Repositories;

class ExchangeRateRepository
{
    /**
     * 取得各幣別匯率
     * 
     * @return object  各幣別匯率
     */
    public function getRate(): object
    {
        return $this->rate() ?? [];
    }

    /**
     * 匯率
     * 
     * @return object 各幣別匯率
     */
    private function rate(): object
    {
        $rate = json_decode('{"currencies": {"TWD": {"TWD": 1,"JPY": 3.669,"USD": 0.03281},"JPY": {"TWD": 0.26956,"JPY": 1,"USD": 0.00885},"USD": {"TWD": 30.444,"JPY": 111.801,"USD": 1}}}');
        return $rate->currencies;
    }
}