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

    /**
     * 匯率轉換 service
     */
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
        try {
            $requestData = $request->only(['from', 'to', 'amount']);
                
            $ratio = $this->currencyConversionService->getRatio(
                $requestData['from'], 
                $requestData['to']
            );
            
            $amount = $this->currencyConversionService->convert(
                $requestData['amount'],
                $ratio
            );

            $responseData = [
                'from' => $requestData['from'],
                'to' => $requestData['to'],
                'amount' => $requestData['amount'],
                'conversionAmount' => $amount,
            ];
    
            return $this->sendResponse(
                'successfully',
                new CurrencyConversionResource($responseData),
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
