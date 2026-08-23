<?php

namespace App\Http\Requests\Admins;

use App\Enums\AdminStatus;
use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class AdminRequest extends BaseRequest
{
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
            'email' => [
                'required',
                'string',
                'email',
                Rule::unique('admins', 'email')->ignore($this->route('admin'))
            ],
            'status' => [
                Rule::enum(AdminStatus::class)
            ],
            'phone' => [
                'nullable',
                'string',
                'regex:/^0[1-9]\d{8}(\d{2})?$/',
                'min:10',
                'max:11',
                Rule::unique('admins','phone')->ignore($this->admin, 'id')
            ],
            'password' => [
                'required',
                'confirmed',
                Password::min(8)->uncompromised()
            ],
            'file' => [
                'nullable',
                'image',
                'mimes:jpeg,png,jpg,gif|max:2048'
            ],
        ];
    }
}
