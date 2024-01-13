<?php

namespace App\Http\Requests\Admin\AdminHomePage;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class FooterUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'description'       => ['string', 'max:255'],
            'privacyPolicyLink' => ['string', 'max:255', 'nullable'],
        ];
    }
}
