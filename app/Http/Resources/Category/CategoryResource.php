<?php

namespace App\Http\Resources\Category;

use App\Http\Resources\User\SupportResource;
use App\Repositories\Categories\Iterators\PrivateCategoryIterator;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

class CategoryResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    #[OA\Schema(
        schema: 'Category',
        description: 'Show information about category',
        properties: [
            new OA\Property(
                property: 'id',
                type: 'integer',
            ),
            new OA\Property(
                property: 'parentId',
                description: 'Integer or null',
                type: 'integer',
            ),
            new OA\Property(
                property: 'icon',
                type: 'string',
            ),
            new OA\Property(
                property: 'title',
                type: 'string',
            ),
            new OA\Property(
                property: 'slug',
                type: 'string',
            ),
            new OA\Property(
                property: 'createdBy',
                ref: '#/components/schemas/Support',
            ),
            new OA\Property(
                property: 'updatedBy',
                ref: '#/components/schemas/Support',
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
                'parentId' => null,
                'icon' => 'category1.png',
                'title' => 'Макіяж',
                'slug' => 'makiyazh',
                'createdBy' => [
                    'id'        => 1,
                    'firstName' => 'Марк',
                    'lastName'  => 'Косенко',
                    'email'     => 'mark.kosenko@gmail.com',
                ],
                'updatedBy' => [
                    'id'        => 6,
                    'firstName' => 'Ганна',
                    'lastName'  => 'Носенко',
                    'email'     => 'hanna.nosenko@gmail.com',
                ],
                'createdAt' => '2023-12-02 14:51:18',
                'updatedAt' => '2023-12-12 16:26:18',
            ],
        ],
    )]
    public function toArray(Request $request): array
    {
        /** @var PrivateCategoryIterator $resource */
        $resource = $this->resource;

        return [
            'id'        => $resource->getId(),
            'parentId'  => $resource->getParentId(),
            'icon'      => $resource->getIcon(),
            'title'     => $resource->getTitle(),
            'slug'      => $resource->getSlug(),
            'createdBy' => new SupportResource($resource->getCreatedBy()),
            'updatedBy' => new SupportResource($resource->getUpdatedBy()),
            'createdAt' => $resource->getCreatedAt(),
            'updatedAt' => $resource->getUpdatedAt(),
        ];
    }
}
