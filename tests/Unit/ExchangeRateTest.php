<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\ExchangeRateService;

class ExchangeRateTest extends TestCase
{
    private $exchangeRateServiceMock;
    private $exchangeRateService;

    public function setUp(): void
    {
        parent::setUp();
        $this->exchangeRateServiceMock = \Mockery::mock(ExchangeRateService::class);
        $this->exchangeRateService = app(ExchangeRateService::class);
    }

    /**
     * 測試取得匯率
     */
    public function test_exchange_rate_get_ratio()
    {
        $this->exchangeRateServiceMock
            ->shouldReceive('ratio')
            ->once()
            ->andReturn($this->ratio());

        $form = 'TWD';
        $to   = 'USD';
    
        $mockResult = $this->exchangeRateServiceMock->ratio();

        $ratio = $this->exchangeRateService->getRatio($form, $to);

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
}
