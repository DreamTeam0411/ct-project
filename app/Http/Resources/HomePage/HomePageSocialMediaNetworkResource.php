<?php

namespace App\Http\Resources\HomePage;

use App\Repositories\SocialMediaNetwork\Iterators\HomePageSocialMediaNetworkIterator;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

class HomePageSocialMediaNetworkResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    #[OA\Schema(
        schema: 'SocialMedia',
        description: 'Show all social media links',
        properties: [
            new OA\Property(
                property: 'title',
                type: 'string',
            ),
            new OA\Property(
                property: 'link',
                type: 'string',
            ),
            new OA\Property(
                property: 'icon',
                type: 'string',
            ),
        ]
    )]
    public function toArray(Request $request): array
    {
        /** @var HomePageSocialMediaNetworkIterator $resource */
        $resource = $this->resource;

        return [
            'title' => $resource->getTitle(),
            'link'  => $resource->getLink(),
            'icon'  => $resource->getIcon(),
        ];
    }
}
