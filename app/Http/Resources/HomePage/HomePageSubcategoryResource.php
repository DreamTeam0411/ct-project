<?php

namespace App\Http\Resources\HomePage;

use App\Repositories\Categories\Iterators\PublicSubcategoryIterator;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

class HomePageSubcategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    #[OA\Schema(
        schema: 'Subcategories',
        description: 'Show all subcategories',
        properties: [
            new OA\Property(
                property: 'title',
                type: 'string',
            ),
            new OA\Property(
                property: 'slug',
                type: 'string',
            ),
        ]
    )]
    public function toArray(Request $request): array
    {
        /** @var PublicSubcategoryIterator $resource */
        $resource = $this->resource;

        return [
            'title' => $resource->getTitle(),
            'slug'  => $resource->getSlug(),
        ];
    }
}
