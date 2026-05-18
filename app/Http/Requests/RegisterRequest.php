<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'max:55'],
            'last_name' => ['required', 'string', 'max:55'],
            'middle_name' => ['nullable', 'string', 'max:55'],
            'suffix_name' => ['nullable', 'string', 'max:10'],
            'birth_date' => ['required', 'date', 'before:today'],
            'gender_id' => ['required', 'exists:genders,gender_id'],
            'address' => ['required', 'string', 'max:255'],
            'contact_number' => ['required', 'string', 'max:20'],
            'email' => ['required', 'email', 'max:55', 'unique:users,email'],
            'username' => ['required', 'string', 'max:55', 'unique:users,username', 'alpha_dash'],
            'password' => ['required', 'confirmed', Password::min(6)],
        ];
    }

    protected function passedValidation(): void
    {
        $this->merge(['role' => 'cashier']);
    }
}
