<?php

namespace App\Http\Resources\HomePage;

use App\Repositories\HomePageCategories\Iterators\HomePageCategoriesBlockIterator;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

class HomePageCategoriesBlockResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    #[OA\Schema(
        schema: 'CategoriesBlock',
        description: 'Show categories block title and description',
        properties: [
            new OA\Property(
                property: 'title',
                type: 'string',
            ),
            new OA\Property(
                property: 'description',
                type: 'string',
            ),
        ]
    )]
    public function toArray(Request $request): array
    {
        /** @var HomePageCategoriesBlockIterator $resource */
        $resource = $this->resource;

        return [
            'title'         => $resource->getTitle(),
            'description'   => $resource->getDescription(),
        ];
    }
}
