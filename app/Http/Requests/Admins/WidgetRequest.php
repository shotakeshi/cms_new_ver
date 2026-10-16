<?php

namespace App\Http\Requests\Admins;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class WidgetRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
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
                Rule::unique('widgets', 'slug')
                    ->ignore($this->route('widget'))
            ],

            'type' => [
                'required',
                'string',
                'max:100',
            ],

            'status' => [
                'required',
                'boolean',
            ],
        ];
    }
}