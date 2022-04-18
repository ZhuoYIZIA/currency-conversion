<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Services\ExchangeRateService;
use Mockery\MockInterface;

class ConversionTest extends TestCase
{
    private $currency_conversion_endpoint = '/api/currency_conversion';

    /**
     * 測試轉換費率 API OK
     */
    public function test_currency_conversion_ok()
    {
        $this->mock(ExchangeRateService::class, function (MockInterface $mock) {
            $mock->shouldReceive('getRatio')
                 ->once()
                 ->andReturn($this->getRatio());
        });

        $apiParam = [
            'from' => 'TWD',
            'to' => 'JPY',
            'amount' => 1000
        ];
        
        $response = $this->call('GET', $this->currency_conversion_endpoint, $apiParam);

        $response->assertStatus(200);
        $response->assertJson([
            'status' => true,
            'message' => 'successfully',
            'data' => [
                'amount' => '3,669.00'
            ]
        ]);
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

    /**
     * 測試 conversion API validator
     * 
     * @dataProvider validator_provider
     */
    public function test_currency_conversion_validator($from, $to, $amount)
    {
        $param = [
            'from' => $from,
            'to' => $to,
            'amount' => $amount,
        ];
        $response = $this->call('GET', $this->currency_conversion_endpoint, $param);

        $response->assertStatus(422);
        
        $response->assertJsonStructure([
            'status',
            'message',
            'data',
        ]);
    }

    public function validator_provider()
    {
        return [
            // required
            [null, 'USD', 1000],
            ['TWD', null, 1000],
            ['TWD', 'USD', null],
            ['TWD', null, null],
            [null, 'USD', null],
            [null, null, 1000],
            [null, null, null],
            // type
            [222, 'USD', 1000],
            ['TWD', 333, 1000],
            ['TWD', 'USD', 'str'],
        ];
    }

    /**
     * 測試無效貨幣
     * 
     * @dataProvider currency_not_found_provider
     */
    public function test_currency_not_found($from, $to)
    {
        $param = [
            'from' => $from,
            'to' => $to,
            'amount' => 10000,
        ];
        $response = $this->call('GET', $this->currency_conversion_endpoint, $param);

        $response->assertStatus(400);
        
        $response->assertJsonStructure([
            'status',
            'message',
            'data',
        ]);
    }

    public function currency_not_found_provider()
    {
        return [
            ['aaa', 'USD'],
            ['TWD', 'bbb'],
        ];
    }

}
