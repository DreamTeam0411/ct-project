<?php

namespace App\Http\Resources\User;

use App\Repositories\UserRepository\Iterators\BusinessIterator;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

class BusinessResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    #[OA\Schema(
        schema: 'Business',
        description: 'Show information about user with business role',
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
                property: 'phoneNumber',
                type: 'string',
            ),
            new OA\Property(
                property: 'address',
                type: 'string',
            ),
        ]
    )]
    public function toArray(Request $request): array
    {
        /** @var BusinessIterator $resource */
        $resource = $this->resource;

        return [
            'id'            => $resource->getId(),
            'firstName'     => $resource->getFirstName(),
            'lastName'      => $resource->getLastName(),
            'phoneNumber'   => $resource->getPhoneNumber(),
            'address'       => $resource->getAddress(),
        ];
    }
}
