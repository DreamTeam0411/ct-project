<?php

namespace App\Http\Resources\HomePage;

use App\Repositories\HomePageHeaderBlock\Iterators\HomePageHeaderBlockIterator;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

class HomePageHeaderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    #[OA\Schema(
        schema: 'Header',
        description: 'Show header',
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
        /** @var HomePageHeaderBlockIterator $resource */
        $resource = $this->resource;

        return [
            'title'         => $resource->getTitle(),
            'description'   => $resource->getDescription(),
        ];
    }
}
