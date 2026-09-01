<?php

namespace App\Http\Requests\Admins;

use App\Enums\DefaultStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BlogCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $blogCategory = $this->route('blog_category');
        $content = $blogCategory?->contents()
            ->where('language_code', $this->input('language_code'))
            ->first();
        return [
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'slug' => [
                'required',
                'string',
                'max:255',
                'alpha_dash:ascii',

                Rule::unique('blog_category_contents', 'slug')
                    ->where(
                        fn ($query) => $query->where(
                            'language_code',
                            $this->input('language_code')
                        )
                    )
                    ->ignore($content?->id),
            ],

            'parent_id' => [
                'nullable',
                'integer',
                'exists:blog_categories,id',
            ],
        ];
    }
}