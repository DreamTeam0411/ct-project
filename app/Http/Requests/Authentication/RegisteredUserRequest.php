<?php

namespace App\Http\Requests\Authentication;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class RegisteredUserRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'firstName' => ['required', 'string', 'max:255'],
            'lastName'  => ['required', 'string', 'max:255'],
            'phoneNumber' => ['required', 'string', 'regex:/^([0-9]*)$/', 'min:4', 'max:30'],
            'email' => ['required', 'unique:users', 'max:255'],
            'password' => [
                'required',
                'max:255',
                'confirmed',
                Password::min(6)
                    ->mixedCase()
                    ->numbers()
                ],
        ];
    }
}
