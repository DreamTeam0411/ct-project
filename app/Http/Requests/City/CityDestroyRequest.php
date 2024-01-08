<?php

namespace App\Http\Requests\City;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CityDestroyRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'id' => ['integer', 'required', 'exists:cities,id']
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'id' => $this->route('city'),
        ]);
    }
}
