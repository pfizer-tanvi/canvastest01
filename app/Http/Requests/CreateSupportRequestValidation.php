<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Gate;

class CreateSupportRequestValidation extends FormRequest
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
        $rules = [
            'title' => "required",
            "description" => "required"
        ];

        if (Gate::allows('feature-flag', 'support-request-type')) {
            $rules = array_merge($rules, ['type' => 'required']);
        }

        return $rules;
    }
}
