<?php

namespace App\Http\Requests;

use App\Utils\Constants\ResponseMessages;
use App\Utils\Enums\HttpResponseEnum;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateProductRequest extends FormRequest
{
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'price' => 'required|integer',
            'category_id' => 'required|exists:App\Models\Category,id',
            'active' => 'required|boolean',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            \ResponseHelper::GetErrorFromRequest(
                ResponseMessages::REQUEST_MODEL_ERROR_RESPONSE,
                $validator->errors(),
                HttpResponseEnum::HTTP_UNPROCESSABLE_ENTITY
            )
        );
    }
}
