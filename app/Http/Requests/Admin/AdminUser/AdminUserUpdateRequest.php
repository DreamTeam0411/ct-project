<?php

namespace App\Http\Requests\Admin\AdminUser;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class AdminUserUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'id'            => ['integer', 'exists:users,id', 'required'],
            'firstName'     => ['string', 'max:255'],
            'lastName'      => ['string', 'max:255'],
            'phoneNumber'   => ['string', 'regex:/^([0-9]*)$/', 'min:4', 'max:30'],
            'address'       => ['string', 'nullable', 'max:255'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'id' => $this->route('user'),
        ]);
    }
}
