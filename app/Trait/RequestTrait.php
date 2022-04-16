<?php

namespace App\Trait;

use Illuminate\Http\Exceptions\HttpResponseException;

Trait RequestTrait
{
    /**
     * @param string $message 回傳訊息
     * @param mixed  $data    回傳資料
     * @param int    $code    http code
     * 
     * @throws Illuminate\Http\Exceptions\HttpResponseException
     */
    public function error(?string $message, mixed $data, int $code)
    {
        throw new HttpResponseException(response()->json([
            'status'  => false,
            'message' => $message,
            'data'    => $data,
        ], $code));
    }
}
