<?php

namespace App\Http\Requests\Category;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CategoryStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'parentId'  => ['integer', 'nullable', 'exists:categories,id'],
            'title'     => ['string', 'required'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'parentId' => $this->parentId ?? null,
        ]);
    }
}
