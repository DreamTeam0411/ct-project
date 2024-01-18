<?php

namespace App\Http\Resources\Category;

use App\Repositories\Categories\Iterators\SubcategoryIterator;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

class CategoryIdNameSlugResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    #[OA\Schema(
        schema: 'CategoryIdNameSlug',
        description: 'Show information about category',
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
        /** @var SubcategoryIterator $resource */
        $resource = $this->resource;

        return [
            'id'    => $resource->getId(),
            'title' => $resource->getTitle(),
            'slug'  => $resource->getSlug(),
        ];
    }
}
