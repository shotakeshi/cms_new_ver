<?php

namespace App\Http\Requests\Admins;

use Illuminate\Foundation\Http\FormRequest;

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
                'unique:widgets,slug,' . $this->route('widget'),
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