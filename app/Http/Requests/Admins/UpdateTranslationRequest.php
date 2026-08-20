<?php

namespace App\Http\Requests\Admins;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTranslationRequest extends FormRequest
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
            'locale' => 'required|string',
            'key'    => 'required|string',
            'value'  => 'nullable|string',
        ];
    }

    protected function passedValidation(): void
    {
        [$group, $dotKey] = explode('.', $this->key, 2);
        $this->merge([
            'group'  => trim($group),
            'dotKey' => trim($dotKey),
        ]);
    }
}
