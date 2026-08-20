<?php

namespace App\Http\Requests\Admins;

use App\Helpers\TranslationHelper;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class CreateTranslationRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'group_key' => ['required', 'regex:/^[a-z0-9_-]+\.[a-z0-9_.-]+$/i'],
            'values'    => ['required', 'array'],
            'values.*'  => ['required', 'string'],
        ];
    }

    protected function passedValidation(): void
    {
        [$group, $dotKey] = explode('.', $this->group_key, 2);

        if (TranslationHelper::groupExists($group) === false) {
            throw ValidationException::withMessages([
                'group_key' => __('site.translation.group_not_exists'),
            ]);
        }

        $this->merge([
            'group'  => trim($group),
            'dotKey' => trim($dotKey),
        ]);
    }

    /**
     * Optional: message custom cho UI
     */
    public function messages(): array
    {
        return [
            'group_key.required' => __('site.translation.group_key_required'),
            'group_key.regex'    => __('site.translation.group_key_format'),
        ];
    }
}
