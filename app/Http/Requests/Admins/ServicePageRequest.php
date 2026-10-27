<?php

namespace App\Http\Requests\Admins;

use App\Enums\DefaultStatus;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ServicePageRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $servicePage = $this->route('service_page');
        $language_code = $this->input('language_code');
        $content = $servicePage?->contents()
            ->where('language_code', $language_code)
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
                'alpha_dash:ascii',
                Rule::unique('service_page_contents', 'slug')
                    ->where(
                        fn ($query) => $query->where(
                            'language_code',
                            $language_code
                        )
                    )
                    ->ignore($content?->id),
            ],
            'content' => [
                'required',
                'string',
            ],
            'status' => [
                'required',
                Rule::enum(DefaultStatus::class),
            ],
            'meta_title' => [
                'nullable',
                'string',
                'max:60',
            ],
            'meta_description' => [
                'nullable',
                'string',
                'max:150',
            ],
            'meta_keywords' => [
                'nullable',
                'string',
            ],
            'file' => [
                'nullable',
                'image',
                'mimes:jpeg,png,jpg,gif,webp',
                'max:2048',
            ],
            'service_page_id' => [
                'nullable',
                'string',
            ],
            'language_code' => [
                'nullable',
                'string',
            ],
        ];
    }
}
