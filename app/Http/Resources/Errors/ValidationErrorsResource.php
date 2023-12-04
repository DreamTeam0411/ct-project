<?php

namespace App\Http\Resources\Errors;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Validation\ValidationException;
use OpenApi\Attributes as OA;

class ValidationErrorsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    #[OA\Schema(
        schema: 'ValidationErrors',
        description: 'Validation Errors',
        properties: [
            new OA\Property(
                property: 'message',
                type: 'string'
            ),
            new OA\Property(
                property: 'errors',
                description: "each key describes error message",
                properties: [
                    new OA\Property(
                        property: 'inputName',
                        type: 'array',
                        items: new OA\Items(),
                    ),
                ],
                type: 'object'
            ),
        ]
    )]
    public function toArray(Request $request): array
    {
        /** @var ValidationException $validation */
        $validation = $this->resource;

        return [
            'message'      => $validation->getMessage(),
            'errors'       => $validation->errors(),
        ];
    }
}
