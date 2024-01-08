<?php

namespace App\Http\Requests\Category;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CategoryIndexRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'lastId' => ['integer', 'min:0']
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'lastId' => $this->lastId ?? 0,
        ]);
    }
}
