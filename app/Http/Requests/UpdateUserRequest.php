<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $userId = $this->route('id');

        return [
            'first_name' => ['required', 'string', 'max:55'],
            'middle_name' => ['nullable', 'string', 'max:55'],
            'last_name' => ['required', 'string', 'max:55'],
            'suffix_name' => ['nullable', 'string', 'max:10'],
            'birth_date' => ['required', 'date', 'before:today'],
            'gender_id' => ['required', 'exists:genders,gender_id'],
            'address' => ['required', 'string', 'max:255'],
            'contact_number' => ['required', 'string', 'max:20'],
            'email' => ['required', 'email', 'max:55', Rule::unique('users', 'email')->ignore($userId, 'user_id')],
            'username' => ['required', 'string', 'max:55', Rule::unique('users', 'username')->ignore($userId, 'user_id')],
            'role' => ['required', Rule::in(['admin', 'cashier'])],
            'photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],
        ];
    }
}
