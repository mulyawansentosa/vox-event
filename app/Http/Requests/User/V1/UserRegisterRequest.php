<?php

namespace App\Http\Requests\User\V1;

use Illuminate\Foundation\Http\FormRequest;

class UserRegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            "firstName" => "required|string|min:3",
            "lastName" => "required|string|min:3",
            "email" => "required|email:dns",
            "password" => "required|min:8|string",
            "repeatPassword" => "required|min:8|string|same:password"
        ];
    }
}
