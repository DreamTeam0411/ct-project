<?php

namespace App\Http\Requests\Admin\AdminService;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;

class AdminServiceStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'categoryId'    => ['integer', 'required', 'exists:categories,id'],
            'title'         => ['string', 'required', 'max:255'],
            'description'   => ['string', 'required', 'max:500'],
            'photo'         => [
                'required',
                //@TODO: image dimensions and size
                File::image()
                    ->types('image/jpeg')
            ],
            'userId'        => ['integer', 'required', 'exists:users,id'],
            'price'         => ['regex:/^\d*(\.\d{2})?$/', 'required'],
            'cityId'        => ['integer', 'required', 'exists:cities,id'],
        ];
    }
}
