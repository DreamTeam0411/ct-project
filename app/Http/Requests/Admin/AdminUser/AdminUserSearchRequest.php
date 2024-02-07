<?php

namespace App\Http\Requests\Admin\AdminUser;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class AdminUserSearchRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'searchInput' => ['string', 'max:255', 'sometimes'],
        ];
    }
}
