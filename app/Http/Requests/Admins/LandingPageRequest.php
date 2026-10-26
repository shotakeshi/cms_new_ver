<?php

namespace App\Http\Requests\Admins;

use App\Enums\DefaultStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class LandingPageRequest extends FormRequest
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
        $landingPage = $this->route('landing_page');
        $content = $landingPage?->contents()
            ->where('language_code', $this->input('language_code'))
            ->first();
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
                Rule::unique('landing_page_contents', 'slug')
                    ->where(
                        fn ($query) => $query->where(
                            'language_code',
                            $this->input('language_code')
                        )
                    )
                    ->ignore($content?->id),
            ],
            'content' => [
                'required',
                'string'
            ],
            'status' => [
                'required',
                Rule::enum(DefaultStatus::class)
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
            'landing_page_id' => [
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
