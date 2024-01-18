<?php

namespace App\Http\Resources\City;

use App\Repositories\Cities\Iterators\CityIdNameAndSlugIterator;
use App\Repositories\Cities\Iterators\CityNameAndSlugIterator;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

class CityNameAndSlugResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    #[OA\Schema(
        schema: 'CityNameAndSlug',
        description: 'Show information about city name and slug',
        properties: [
            new OA\Property(
                property: 'name',
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
        /** @var CityNameAndSlugIterator $resource */
        $resource = $this->resource;

        return [
            'name'  => $resource->getName(),
            'slug'  => $resource->getSlug(),
        ];
    }
}
