<?php

namespace App\Http\Requests\Admins;

use App\Enums\AdminStatus;
use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class AdminChangePasswordRequest extends BaseRequest
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
            'current_password' => [
                'required_with:password',
                'current_password:admin'
            ],
            'password' => [
                'confirmed',
                'different:current_password',
                Password::min(8)->uncompromised(),
            ]
        ];
    }
}