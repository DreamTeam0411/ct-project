<?php

namespace App\Http\Resources\HomePage;

use App\Repositories\HomePageAboutUsBlock\Iterators\HomePageAboutUsBlockIterator;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

class HomePageAboutUsBlockResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    #[OA\Schema(
        schema: 'AboutUsBlock',
        description: 'Show About Us block data',
        properties: [
            new OA\Property(
                property: 'title',
                type: 'string',
            ),
            new OA\Property(
                property: 'description',
                type: 'string',
            ),
            new OA\Property(
                property: 'image',
                type: 'string',
            ),
        ]
    )]
    public function toArray(Request $request): array
    {
        /** @var HomePageAboutUsBlockIterator $resource */
        $resource = $this->resource;

        return [
            'title'         => $resource->getTitle(),
            'description'   => $resource->getDescription(),
            'image'         => $resource->getImage(),
        ];
    }
}
