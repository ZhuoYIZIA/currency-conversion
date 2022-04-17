<?php

namespace App\Exceptions;

use Exception;

class ConversionExcaption extends Exception
{
    protected $code;
    protected $message;
    protected $status;

    /**
     * 錯誤處理
     * 
     * @param string $message 錯誤訊息
     * @param int    $code    錯誤代碼
     * @param bool   $status  錯誤狀態
     */
    public function error(?string $message, ?int $code, ?bool $status)
    {
        $this->message = $message ?? 'error';
        $this->code    = $code ?? 400;
        $this->status  = $status;

        throw $this;
    }
}
