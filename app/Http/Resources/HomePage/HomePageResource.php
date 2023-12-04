<?php

namespace App\Http\Resources\HomePage;

use App\Services\HomePage\Iterators\HomePageIterator;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

class HomePageResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    #[OA\Schema(
        schema: 'Homepage',
        description: 'Show homepage data',
        properties: [
            new OA\Property(
                property: 'data',
                properties: [
                    new OA\Property(
                        property: 'logo',
                        type: 'string',
                    ),
                    new OA\Property(
                        property: 'links',
                        type: 'array',
                        items: new OA\Items(
                            ref: '#/components/schemas/Links'
                        ),
                    ),
                    new OA\Property(
                        property: 'header',
                        type: 'array',
                        items: new OA\Items(
                            ref: '#/components/schemas/Header'
                        ),
                    ),
                    new OA\Property(
                        property: 'categoriesBlock',
                        type: 'array',
                        items: new OA\Items(
                            ref: '#/components/schemas/CategoriesBlock'
                        ),
                    ),
                    new OA\Property(
                        property: 'categoriesContent',
                        type: 'array',
                        items: new OA\Items(
                            ref: '#/components/schemas/CategoriesContent'
                        ),
                    ),
                    new OA\Property(
                        property: 'aboutUsBlock',
                        type: 'array',
                        items: new OA\Items(
                            ref: '#/components/schemas/AboutUsBlock'
                        ),
                    ),
                    new OA\Property(
                        property: 'footer',
                        type: 'array',
                        items: new OA\Items(
                            ref: '#/components/schemas/Footer'
                        ),
                    ),
                    new OA\Property(
                        property: 'socialMedia',
                        type: 'array',
                        items: new OA\Items(
                            ref: '#/components/schemas/SocialMedia'
                        ),
                    ),
                ],
                type: 'object',
            ),
        ]
    )]
    public function toArray(Request $request): array
    {
        /** @var HomePageIterator $resource */
        $resource = $this->resource;

        return [
            'logo'              => $resource->getLogo(),
            'links'             => HomePageLinksResource::collection($resource->getLinks()),
            'header'            => new HomePageHeaderResource($resource->getHeader()),
            'categoriesBlock'   => new HomePageCategoriesBlockResource($resource->getCategoriesBlock()),
            'categoriesContent' => HomePageCategoryResource::collection(
                $resource->getCategoriesContent()->getIterator()->getArrayCopy()
            ),
            'aboutUsBlock'      => HomePageAboutUsBlockResource::collection($resource->getAboutUsBlock()),
            'footer'            => new HomePageFooterBlockResource($resource->getFooterBlock()),
            'socialMedia'       => HomePageSocialMediaNetworkResource::collection($resource->getSocialMedia())
        ];
    }
}
