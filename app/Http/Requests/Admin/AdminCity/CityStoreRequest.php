<?php

namespace App\Http\Requests\Admin\AdminCity;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CityStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'countryId' => ['integer', 'required', 'exists:countries,id'],
            'parentId'  => ['integer', 'nullable', 'exists:cities,id'],
            'name'      => ['string', 'required', 'max:255'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'parentId'  => $this->parentId ?? null,
        ]);
    }
}
