<?php

namespace App\Http\Resources\User;

use App\Services\EmailVerificationService\EmailVerifyDTO;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

class EmailVerificationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    #[OA\Schema(
        schema: 'EmailVerification',
        description: 'Show email verification data',
        properties: [
            new OA\Property(
                property: 'id',
                type: 'integer',
            ),
            new OA\Property(
                property: 'expires',
                type: 'integer',
            ),
            new OA\Property(
                property: 'hash',
                type: 'string',
            ),
            new OA\Property(
                property: 'signature',
                type: 'string',
            ),
        ]
    )]
    public function toArray(Request $request): array
    {
        /** @var EmailVerifyDTO $resource */
        $resource = $this->resource;

        return [
            'id'        => $resource->getId(),
            'expires'   => $resource->getExpires(),
            'hash'      => $resource->getHash(),
            'signature' => $resource->getSignature(),
        ];
    }
}
