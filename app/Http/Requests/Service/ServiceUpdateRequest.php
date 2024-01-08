<?php

namespace App\Http\Requests\Service;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ServiceUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'id'            => ['integer', 'required', 'exists:services,id'],
            'categoryId'    => ['integer', 'exists:categories,id'],
            'title'         => ['string', 'max:255'],
            'description'   => ['string', 'max:500'],
            'price'         => ['regex:/^\d*(\.\d{2})?$/', 'required'],
            'cityId'        => ['integer', 'exists:cities,id'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'id' => $this->route('service'),
        ]);
    }
}
