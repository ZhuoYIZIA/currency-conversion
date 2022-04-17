<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\CurrencyConversionService;
use App\Exceptions\ConversionExcaption;

class CurrencyConversionTest extends TestCase
{
    /**
     * 測試匯率轉換
     */
    public function test_currency_conversion_convert()
    {
        $currencyConversionService = new CurrencyConversionService(new ConversionExcaption);
        $amount = $currencyConversionService->convert(1000, $this->getRatio());

        $this->assertTrue($amount === '3,669.00');
    }

    /**
     * 匯率
     * 
     * @return float 匯率
     */
    private function getRatio(): float
    {
        return 3.669;
    }
}
