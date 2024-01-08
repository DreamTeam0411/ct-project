<?php

namespace App\Http\Resources\City;

use App\Http\Resources\Country\CountryIdAndNameResource;
use App\Repositories\Cities\Iterators\PrivateCityIterator;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

class CityResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    #[OA\Schema(
        schema: 'City',
        description: 'Show information about city',
        properties: [
            new OA\Property(
                property: 'id',
                type: 'integer',
            ),
            new OA\Property(
                property: 'country',
                ref: '#/components/schemas/CountryIdNameAndSlug'
            ),
            new OA\Property(
                property: 'parentId',
                description: 'Integer or null',
                type: 'integer',
            ),
            new OA\Property(
                property: 'name',
                type: 'string',
            ),
            new OA\Property(
                property: 'slug',
                type: 'string',
            ),
            new OA\Property(
                property: 'createdAt',
                type: 'string',
            ),
            new OA\Property(
                property: 'updatedAt',
                type: 'string',
            ),
        ],
        example: [
            [
                'id' => 1,
                'country' => [
                    'id'    => 1,
                    'name'  => 'Україна',
                ],
                'parentId' => null,
                'name' => 'Київ',
                'slug' => 'ukrayina-kiyiv',
                'createdAt' => '2023-12-02 14:51:18',
                'updatedAt' => '2023-12-02 14:56:21',
            ],
        ],
    )]
    public function toArray(Request $request): array
    {
        /** @var PrivateCityIterator $resource */
        $resource = $this->resource;

        return [
            'id'        => $resource->getId(),
            'country'   => new CountryIdAndNameResource($resource->getCountry()),
            'parentId'  => $resource->getParentId(),
            'name'      => $resource->getName(),
            'slug'      => $resource->getSlug(),
            'createdAt' => $resource->getCreatedAt(),
            'updatedAt' => $resource->getUpdatedAt(),
        ];
    }
}
