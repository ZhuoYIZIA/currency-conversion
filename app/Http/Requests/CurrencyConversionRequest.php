<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use App\Trait\ResponseTrait;
use Illuminate\Http\Exceptions\HttpResponseException;

class CurrencyConversionRequest extends FormRequest
{
    use ResponseTrait;

    /**
     * Indicates whether validation should stop after the first rule failure.
     *
     * @var bool
     */
    protected $stopOnFirstFailure = false;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'from'   => 'required|string',
            'to'     => 'required|string',
            'amount' => 'required|integer',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException($this->sendResponse(
            $validator->errors()->first(),
            null,
            422,
            false
        ));
    }
}
