<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\CurrencyConversionService;
use App\Exceptions\ConversionExcaption;

class CurrencyConversionTest extends TestCase
{
    private $currencyConversionService;

    public function setUp(): void
    {
        parent::setUp();
        $this->currencyConversionService = app(CurrencyConversionService::class);
    }

    /**
     * 測試匯率轉換
     */
    public function test_currency_conversion_convert()
    {
        $amount = $this->currencyConversionService->convert(1000, $this->getRatio());

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
