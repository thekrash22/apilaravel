<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use App\Utils\Constants\ResponseMessages;
use App\Utils\Enums\HttpResponseEnum;

class UserStoreRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ];
    }
    public function messages()
    {
        return [
            'name.required'         => 'Nombre es required',
            'email.required'        => 'Email required',
            'email.email'           => 'Email debe estar en formato de email',
            'email.unique'          => 'Email existe en el sistema',
            'username.required'     => 'Username requerido',
            'username.unique'       => 'Username existe en el sistema',
            'password'              => 'Password es requeriedo',
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
