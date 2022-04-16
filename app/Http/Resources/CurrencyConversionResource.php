<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Trait\ResponseTrait;

class CurrencyConversionResource extends JsonResource
{
    use ResponseTrait;

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'amount' => $this['amount']
        ];
    }

    public function toResponse($request)
    {
        return parent::toResponse($request)->setStatusCode(200);
    }
}
