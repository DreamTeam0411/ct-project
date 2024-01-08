<?php

namespace App\Http\Resources\User;

use App\Repositories\UserRepository\Iterators\SupportIterator;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

class SupportResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    #[OA\Schema(
        schema: 'Support',
        description: 'Show information about user with support role',
        properties: [
            new OA\Property(
                property: 'id',
                type: 'integer',
            ),
            new OA\Property(
                property: 'firstName',
                type: 'string',
            ),
            new OA\Property(
                property: 'lastName',
                type: 'string',
            ),
            new OA\Property(
                property: 'email',
                type: 'string',
            ),
        ]
    )]
    public function toArray(Request $request): array
    {
        /** @var SupportIterator $resource */
        $resource = $this->resource;

        return [
            'id'            => $resource->getId(),
            'firstName'     => $resource->getFirstName(),
            'lastName'      => $resource->getLastName(),
            'email'         => $resource->getEmail(),
        ];
    }
}
