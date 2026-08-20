<?php

namespace App\Http\Requests\Admins;

use App\Enums\DefaultStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255'
            ],
            'slug' => [
                'required',
                'string',
                'alpha_dash:ascii',
                Rule::unique('pages', 'slug')
                    ->ignore($this->route('page'))
            ],
            'content' => [
                'required',
                'string'
            ],
            'status' => [
                'required',
                Rule::enum(DefaultStatus::class)
            ],
            'status_comment' => [
                'required',
                Rule::enum(DefaultStatus::class)
            ],
            'published_at' => [
                'nullable',
                'date_format:d/m/Y - H:i'
            ],
            "meta_title" => [
                'nullable',
                'string',
                'max:60',
            ],
            "meta_description" => [
                'nullable',
                'string',
                'max:150',
            ],
            "meta_keywords" => [
                'nullable',
                'string',
            ],
            'image' => [
                'nullable',
                'image',
                'mimes:jpeg,png,jpg,gif|max:2048'
            ],
            'page_id' => [
                'nullable',
                'string'
            ],
            'language_code' => [
                'nullable',
                'string'
            ],
        ];
    }
}
