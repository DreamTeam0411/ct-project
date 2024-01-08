<?php

namespace App\Http\Resources\City;

use App\Repositories\Cities\Iterators\CityIdNameAndSlugIterator;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

class CityIdNameAndSlugResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    #[OA\Schema(
        schema: 'CityIdNameAndSlug',
        description: 'Show information about city id, name and slug',
        properties: [
            new OA\Property(
                property: 'id',
                type: 'integer',
            ),
            new OA\Property(
                property: 'title',
                type: 'string',
            ),
            new OA\Property(
                property: 'slug',
                type: 'string',
            ),
        ],
    )]
    public function toArray(Request $request): array
    {
        /** @var CityIdNameAndSlugIterator $resource */
        $resource = $this->resource;

        return [
            'id'    => $resource->getId(),
            'name'  => $resource->getName(),
            'slug'  => $resource->getSlug(),
        ];
    }
}
