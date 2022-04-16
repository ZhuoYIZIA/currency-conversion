<?php

namespace App\Trait;

Trait ResponseTrait
{
    /**
     * @param string $message 回傳訊息
     * @param mixed  $data    回傳資料
     * @param int    $code    http code
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendSuccessResponse(string $message, mixed $data, int $code)
    {
        return response()->json([
            'status'  => true,
            'message' => $message,
            'data'    => $data,
        ], $code);
    }
}
