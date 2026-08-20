<?php

namespace App\Http\Requests\Admins;

use App\Enums\AdminStatus;
use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

class AdminProfileRequest extends BaseRequest
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
            'email' => [
                'required',
                'string',
                'email',
                Rule::unique('admins','email')->ignore($this->admin, 'id')
            ],
            'phone' => [
                'nullable',
                'string',
                'regex:/^0[1-9]\d{8}(\d{2})?$/',
                'min:10',
                'max:11',
                Rule::unique('admins','phone')->ignore($this->admin, 'id')
            ],
            'status' => [
                Rule::enum(AdminStatus::class)
            ],
            'file' => [
                'nullable',
                'image',
                'mimes:jpeg,png,jpg,gif|max:2048'
            ],
        ];
    }
}
