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
            new OA\Property(
                property: 'privacyPolicyLink',
                type: 'string',
                nullable: true,
            ),
            new OA\Property(
                property: 'termsAndCondition',
                type: 'string',
                nullable: true,
            ),
        ]
    )]
    public function toArray(Request $request): array
    {
        /** @var HomePageFooterBlockIterator $resource */
        $resource = $this->resource;

        return [
            'description'       => $resource->getDescription(),
            'privacyPolicyLink' => $resource->getPrivacyPolicyLink(),
            'termsAndCondition' => $resource->getTermsAndCondition(),
        ];
    }
}
