<?php

namespace App\Http\Resources\Service;

use App\Http\Resources\Category\CategoryIdNameSlugResource;
use App\Http\Resources\City\CityIdNameAndSlugResource;
use App\Repositories\Services\Iterators\PrivateServiceIterator;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

class ServiceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    #[OA\Schema(
        schema: 'Service',
        description: 'Show information about service',
        properties: [
            new OA\Property(
                property: 'id',
                type: 'integer',
            ),
            new OA\Property(
                property: 'category',
                type: 'integer',
            ),
            new OA\Property(
                property: 'title',
                type: 'integer',
            ),
            new OA\Property(
                property: 'description',
                type: 'integer',
            ),
            new OA\Property(
                property: 'user',
                properties: [
                    new OA\Property(
                        property: 'id',
                        type: 'integer',
                    ),
                    new OA\Property(
                        property: 'firstName',
                        type: 'string',
                    ),
                    new OA\Property(
                        property: 'lastName',
                        type: 'string',
                    ),
                    new OA\Property(
                        property: 'email',
                        type: 'string',
                    ),
                ],
                type: 'object',
            ),
            new OA\Property(
                property: 'price',
                type: 'number',
                format: 'double'
            ),
            new OA\Property(
                property: 'city',
                ref: '#/components/schemas/CityIdNameAndSlug'
            ),
            new OA\Property(
                property: 'createdAt',
                type: 'integer',
            ),
            new OA\Property(
                property: 'updatedAt',
                type: 'integer',
            ),
        ],
        example: [
            'id' => 1,
            'category'  => [
                'id'    => 4,
                'title' => 'Догляд за нігтями',
                'slug'  => 'doglyad-za-nigtyami',
            ],
            'title'         => 'Заголовок послуги',
            'description'   => 'Детальний опис послуги',
            'user' => [
                'id' => 32,
                'firstName' => 'Олена',
                'lastName'  => 'Новікова',
                'email'     => 'olena.novikova@example.com'
            ],
            'price' => 900.45,
            'city' => [
                'id' => 1,
                'name' => 'Київ',
                'slug' => 'ukrayina-kiyiv',
            ],
            'createdAt' => '2023-12-02 14:51:18',
            'updatedAt' => '2023-12-02 14:51:18',
        ]
    )]
    public function toArray(Request $request): array
    {
        /** @var PrivateServiceIterator $resource */
        $resource = $this->resource;

        return [
            'id'            => $resource->getId(),
            'category'      => new CategoryIdNameSlugResource($resource->getCategory()),
            'title'         => $resource->getTitle(),
            'description'   => $resource->getDescription(),
            'user'          => [
                'id'        => $resource->getUser()->getId(),
                'firstName' => $resource->getUser()->getFirstName(),
                'lastName'  => $resource->getUser()->getLastName(),
                'email'     => $resource->getUser()->getEmail(),
            ],
            'price'         => $resource->getPrice(),
            'city'          => new CityIdNameAndSlugResource($resource->getCity()),
            'createdAt'     => $resource->getCreatedAt(),
            'updatedAt'     => $resource->getUpdatedAt(),
        ];
    }
}
