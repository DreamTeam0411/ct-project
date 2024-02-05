<?php

namespace App\Http\Requests\Admin\AdminCategory;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;

class AdminCategoryStoreRequest extends FormRequest
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
            'icon'      => [
                'required',
                //@TODO: image dimensions and size
                File::image()
                    ->types('image/jpeg')
            ],
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
