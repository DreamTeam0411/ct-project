<?php

namespace App\Http\Resources\HomePage;

use App\Repositories\HomePageFooter\Iterators\HomePageFooterBlockIterator;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

class HomePageFooterBlockResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    #[OA\Schema(
        schema: 'Footer',
        description: 'Show Footer block data',
        properties: [
            new OA\Property(
                property: 'description',
                type: 'string',
            ),
        ]
    )]
    public function toArray(Request $request): array
    {
        /** @var HomePageFooterBlockIterator $resource */
        $resource = $this->resource;

        return [
            'description' => $resource->getDescription(),
        ];
    }
}
