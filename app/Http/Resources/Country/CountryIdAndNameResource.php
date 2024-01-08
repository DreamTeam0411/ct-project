<?php

namespace App\Http\Resources\Country;

use App\Repositories\Countries\Iterators\CountryIdAndNameIterator;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

class CountryIdAndNameResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    #[OA\Schema(
        schema: 'CountryIdNameAndSlug',
        description: 'Show information about country id and name',
        properties: [
            new OA\Property(
                property: 'id',
                type: 'integer',
            ),
            new OA\Property(
                property: 'name',
                type: 'string',
            ),
        ],
    )]
    public function toArray(Request $request): array
    {
        /** @var CountryIdAndNameIterator $resource */
        $resource = $this->resource;

        return [
            'id'    => $resource->getId(),
            'name'  => $resource->getName(),
        ];
    }
}
