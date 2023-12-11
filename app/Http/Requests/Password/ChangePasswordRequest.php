<?php

namespace App\Http\Requests\Password;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class ChangePasswordRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'token' => ['string', 'required'],
            'email' => ['email', 'required'],
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

    protected function prepareForValidation(): void
    {
        $this->merge([
            'token' => $this->route('token')
        ]);
    }
}
