<?php

namespace App\Http\Controllers;

use Throwable;
use Illuminate\Http\Request;
use App\Http\Requests\CurrencyConversionRequest;
use App\Services\CurrencyConversionService;
use App\Services\ExchangeRateService;
use App\Http\Resources\CurrencyConversionResource;
use App\Trait\ResponseTrait;

class CurrencyController extends Controller
{
    use ResponseTrait;

    /**
     * 匯率轉換 service
     */
    private $currencyConversionService;

    /**
     * 取得匯率 service
     */
    private $exchangeRateService;

    public function __construct(
        CurrencyConversionService $currencyConversionService,
        ExchangeRateService $exchangeRateService
    ){
        $this->currencyConversionService = $currencyConversionService;
        $this->exchangeRateService = $exchangeRateService;
    }

    /**
     * 轉換匯率
     * 
     * @param  CurrencyConversionRequest  $request 
     * 
     * @return CurrencyConversionResource 回傳轉換後金額
     */
    public function conversion(CurrencyConversionRequest $request)
    {
        try {
            $requestData = $request->only(['from', 'to', 'amount']);
                
            $ratio = $this->exchangeRateService->getRatio(
                $requestData['from'], 
                $requestData['to']
            );
            
            $amount = $this->currencyConversionService->convert(
                $requestData['amount'],
                $ratio
            );
    
            return $this->sendResponse(
                'successfully',
                new CurrencyConversionResource(compact('amount')),
                200,
                true
            );
        } catch (Throwable $e) {
            return $this->sendResponse(
                $e->getMessage(),
                null,
                $e->getCode(),
                false
            );
        }
    }
}
