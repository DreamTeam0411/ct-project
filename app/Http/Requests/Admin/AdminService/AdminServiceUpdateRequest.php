<?php

namespace App\Http\Requests\Admin\AdminService;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;

class AdminServiceUpdateRequest extends FormRequest
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
            'firstName'     => ['string', 'max:255'],
            'lastName'      => ['string', 'max:255'],
            'phoneNumber'   => ['string', 'max:255'],
            'link'          => ['string', 'max:255'],
            'address'       => ['string', 'max:255'],
            'price'         => ['regex:/^\d*(\.\d{2})?$/', 'required'],
            'cityId'        => ['integer', 'exists:cities,id'],
            'photo'         => [
                'sometimes',
                //@TODO: image dimensions and size
                File::image()
                    ->types('image/jpeg')
            ],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'id' => $this->route('service'),
        ]);
    }
}
