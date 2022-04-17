<?php

namespace App\Trait;

Trait ResponseTrait
{
    /**
     * @param string $message 回傳訊息
     * @param mixed  $data    回傳資料
     * @param int    $code    回傳代碼
     * @param bool   $status  回傳狀態
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendResponse(string $message, mixed $data, int $code, bool $status)
    {
        return response()->json([
            'status'  => $status,
            'message' => $message,
            'data'    => $data,
        ], $code);
    }
}
