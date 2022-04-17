<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\CurrencyConversionService;
use App\Repositories\ExchangeRateRepository;
use App\Exceptions\ConversionExcaption;
use Mockery\MockInterface;

class CurrencyConversionTest extends TestCase
{
    /**
     * 測試匯率轉換
     */
    public function test_currency_conversion_convert()
    {
        $this->mock(ExchangeRateRepository::class, function (MockInterface $mock) {
            $mock->shouldReceive('getRate')
                 ->once()
                 ->andReturn($this->rate());
        });

        $currencyConversionService = new CurrencyConversionService(new ExchangeRateRepository, new ConversionExcaption);
        $amount = $currencyConversionService->convert('TWD', 'JPY', 1000);

        $this->assertTrue($amount === '3,669.00');
    }

    /**
     * 匯率
     * 
     * @return object 各幣別匯率
     */
    private function rate(): object
    {
        // $rate = json_decode('{"currencies": {"TWD": {"TWD": 1,"JPY": 3.669}}}');
        $rate = json_decode('{"currencies": {"TWD": {"TWD": 1,"JPY": 4.669}}}');
        return $rate->currencies;
    }
}
