<?php

namespace App\Http\Resources\HomePage;

use App\Repositories\Categories\Iterators\HomePageCategoryIterator;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

class HomePageCategoryResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     * @throws Exception
     */
    #[OA\Schema(
        schema: 'CategoriesContent',
        description: 'Show categories block title and description',
        properties: [
            new OA\Property(
                property: 'title',
                type: 'string',
            ),
            new OA\Property(
                property: 'icon',
                type: 'string',
            ),
            new OA\Property(
                property: 'slug',
                type: 'string',
            ),
            new OA\Property(
                property: 'subcategories',
                type: 'array',
                items: new OA\Items(
                    ref: '#/components/schemas/Subcategories'
                ),
            )
        ]
    )]
    public function toArray(Request $request): array
    {
        /** @var HomePageCategoryIterator $resource */
        $resource = $this->resource;

        return [
            'title'         => $resource->getTitle(),
            'icon'          => $resource->getIcon(),
            'slug'          => $resource->getSlug(),
            'subcategories' => HomePageSubcategoryResource::collection(
                $resource->getSubcategories()->getIterator()->getArrayCopy()
            ),
        ];
    }
}
