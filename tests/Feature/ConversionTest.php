<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ConversionTest extends TestCase
{
    /**
     * test currency conversion
     */
    public function test_currency_conversion()
    {
        $param = [
            'from' => 'TWD',
            'to' => 'USD',
            'amount' => 10099,
        ];
        $response = $this->call('GET', '/api/conversion', $param);

        $response->assertStatus(200);
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
        $response = $this->call('GET', '/api/conversion', $param);

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
        $response = $this->call('GET', '/api/conversion', $param);

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
