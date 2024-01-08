<?php

namespace App\Http\Requests\City;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CityUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'id'        => ['integer', 'required', 'exists:cities,id'],
            'countryId' => ['integer', 'exists:countries,id'],
            'parentId'  => ['integer', 'nullable', 'exists:cities,id'],
            'name'      => ['string', 'max:255'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'id'        => $this->route('city'),
            'parentId'  => $this->parentId ?? null,
        ]);
    }
}
