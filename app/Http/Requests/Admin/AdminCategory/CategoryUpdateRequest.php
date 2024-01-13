<?php

namespace App\Http\Requests\Admin\AdminCategory;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CategoryUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'id'        => ['integer', 'required', 'exists:categories,id'],
            'parentId'  => ['integer', 'nullable', 'exists:categories,id'],
            'title'     => ['string'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'id'        => $this->route('category'),
            'parentId'  => $this->parentId ?? null,
        ]);
    }
}
