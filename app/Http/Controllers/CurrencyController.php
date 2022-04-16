<?php

namespace App\Http\Controllers;

use Throwable;
use Illuminate\Http\Request;
use App\Http\Requests\CurrencyConversionRequest;
use App\Services\CurrencyConversionService;
use App\Http\Resources\CurrencyConversionResource;
use App\Trait\ResponseTrait;

class CurrencyController extends Controller
{
    use ResponseTrait;

    private $currencyConversionService;

    public function __construct(CurrencyConversionService $currencyConversionService)
    {
        $this->currencyConversionService = $currencyConversionService;
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
        $requestData = $request->only(['from', 'to', 'amount']);
            
        $amount = $this->currencyConversionService->convert(
            $requestData['from'],
            $requestData['to'],
            $requestData['amount']
        );

        return $this->sendSuccessResponse(
            'successfully',
            new CurrencyConversionResource(compact('amount')),
            200
        );
    }
}
