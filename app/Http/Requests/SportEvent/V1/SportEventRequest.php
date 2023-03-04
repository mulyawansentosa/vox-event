<?php

namespace App\Http\Requests\SportEvent\V1;

use Illuminate\Foundation\Http\FormRequest;

class SportEventRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            "eventDate" => "required",
            "eventType" => "required",
            "eventName" => "required",
            "organizerId" => "required"
        ];
    }
}
