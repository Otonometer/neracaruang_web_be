<?php

namespace App\Http\Requests;

use App\Enums\ContentTypes;
use App\Enums\LocationTypes;
use Illuminate\Foundation\Http\FormRequest;
use App\Models\Content;
use Illuminate\Validation\Rule;

class CreateContentRequest extends FormRequest
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
            'title' => 'required',
            'content' => [
                Rule::requiredIf(fn() => !in_array($this->input('type_id'), ContentTypes::mediaContents()))
            ],
            'image' => [
                Rule::requiredIf(fn() => !in_array($this->input('type_id'), ContentTypes::mediaContents())),
                'image',
                'mimes:png,jpg,jpeg'
            ],
            'location_type' => 'required',
            'location_id' => [
                Rule::requiredIf(fn() => $this->input('location_type') !== LocationTypes::NATIONAL->value)
            ],
            'video' => [
                Rule::requiredIf(fn() => $this->input('type_id') === ContentTypes::VIDEO->value)
            ],
            'medias' => 'array|min:1',
            'medias.*.image' => [
                Rule::requiredIf(fn() => in_array($this->input('type_id'), ContentTypes::mediaContents())),
                'mimes:png,jpg,jpeg'
            ],
            'medias.*.summary' => [
                Rule::requiredIf(fn() => in_array($this->input('type_id'), ContentTypes::mediaContents())),
            ],
            'created_by' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'created_by' => 'Writer field is required',
            'location_id.requiredif' => 'Location field is required when location type is not National',
            'image.requiredif' => 'Thumbnail is required',
            'medias.*.image.required' => 'Media Image :position is required',
            'medias.*.image.mimes' => 'Media Image :position Format Must Be png,jpg or jpeg',
            'medias.*.summary.required' => 'Media Summary :position is required'
        ];
    }
}