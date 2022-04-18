<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\CurrencyConversionService;

class CurrencyConversionTest extends TestCase
{
    private $currencyConversionServiceMock;
    private $currencyConversionService;

    public function setUp(): void
    {
        parent::setUp();
        $this->currencyConversionServiceMock = \Mockery::mock(CurrencyConversionService::class);
        $this->currencyConversionService = app(CurrencyConversionService::class);
    }

    /**
     * 測試取得匯率
     */
    public function test_currency_conversion_get_ratio()
    {
        $this->currencyConversionServiceMock
            ->shouldReceive('ratio')
            ->once()
            ->andReturn($this->ratio());

        $form = 'TWD';
        $to   = 'USD';
    
        $mockResult = $this->currencyConversionServiceMock->ratio();

        $ratio = $this->currencyConversionService->getRatio($form, $to);

        $this->assertTrue($ratio === $mockResult->$form->$to);
    }

    /**
     * 匯率
     * 
     * @return float 匯率
     */
    private function ratio(): object
    {
        $ratioObject = json_decode('
            {
                "currencies": 
                {
                    "TWD": 
                    {
                        "TWD": 1,
                        "JPY": 3.669,
                        "USD": 0.03281
                    }
                }
            }
        ');
        return $ratioObject->currencies;
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
