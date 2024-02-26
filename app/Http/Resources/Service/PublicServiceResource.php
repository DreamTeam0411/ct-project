<?php

namespace App\Http\Resources\Service;

use App\Http\Resources\Category\CategoryNameAndSlugResource;
use App\Http\Resources\City\CityNameAndSlugResource;
use App\Http\Resources\User\BusinessResource;
use App\Repositories\Services\Iterators\PublicServiceIterator;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

class PublicServiceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    #[OA\Schema(
        schema: 'PublicService',
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
                property: 'photo',
                type: 'string',
            ),
            new OA\Property(
                property: 'user',
                ref: '#/components/schemas/Business'
            ),
            new OA\Property(
                property: 'price',
                type: 'number',
                format: 'double'
            ),
            new OA\Property(
                property: 'city',
                ref: '#/components/schemas/CityNameAndSlug'
            ),
            new OA\Property(
                property: 'createdAt',
                type: 'integer',
            ),
        ],
        example: [
            'id' => 1,
            'category'  => [
                'title' => 'Догляд за нігтями',
                'slug'  => 'doglyad-za-nigtyami',
            ],
            'title'         => 'Заголовок послуги',
            'description'   => 'Детальний опис послуги',
            'photo'         => null,
            'user' => [
                'id'            => 32,
                'firstName'     => 'Олена',
                'lastName'      => 'Новікова',
                'photoNumber'   => '380970000000',
                'address'       => null,
            ],
            'price' => 900.45,
            'city' => [
                'name' => 'Київ',
                'slug' => 'ukrayina-kiyiv',
            ],
            'createdAt' => '2023-12-02 14:51:18',
        ]
    )]
    public function toArray(Request $request): array
    {
        /** @var PublicServiceIterator $resource */
        $resource = $this->resource;

        return [
            'id'            => $resource->getId(),
            'category'      => new CategoryNameAndSlugResource($resource->getCategory()),
            'title'         => $resource->getTitle(),
            'description'   => $resource->getDescription(),
            'photo'         => $resource->getPhoto(),
            'user'          => new BusinessResource($resource->getUser()),
            'price'         => $resource->getPrice(),
            'city'          => new CityNameAndSlugResource($resource->getCity()),
            'createdAt'     => $resource->getCreatedAt(),
        ];
    }
}
