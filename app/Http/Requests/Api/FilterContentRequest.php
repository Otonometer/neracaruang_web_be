<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class FilterContentRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'type' => 'alpha_dash',
            'with_tags' => 'boolean',
            'tags' => 'required_if:with_tags,true|array',
            'city' => 'sometimes',
            'province' => 'sometimes',
            'sort_popular' => 'boolean',
            'keyword' => '',
            'content_slug' => ''
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success'   => false,
            'message'   => 'Validation errors',
            'data'      => $validator->errors()
        ],400));
    }
}
