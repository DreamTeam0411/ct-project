<?php

namespace App\Http\Resources\HomePage;

use App\Repositories\HomePageLinks\Iterators\HomePageLinksIterator;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

class HomePageLinksResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    #[OA\Schema(
        schema: 'Links',
        description: 'Show all links',
        properties: [
            new OA\Property(
                property: 'title',
                type: 'string',
            ),
            new OA\Property(
                property: 'link',
                type: 'string',
            ),
        ]
    )]
    public function toArray(Request $request): array
    {
        /** @var HomePageLinksIterator $resource */
        $resource = $this->resource;

        return [
            'title' => $resource->getTitle(),
            'link' => $resource->getLink(),
        ];
    }
}
