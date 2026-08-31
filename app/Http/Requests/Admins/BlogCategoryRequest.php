<?php

namespace App\Http\Requests\Admins;

use App\Enums\DefaultStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BlogCategoryRequest extends FormRequest
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
                Rule::unique('blog_category_contents', 'slug')
                    ->ignore($this->route('blogCategory')->id, 'id')
            ]
        ];
    }
}
