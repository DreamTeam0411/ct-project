<?php

namespace App\Http\Resources\User;

use App\Repositories\UserRepository\Iterators\UserIterator;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    #[OA\Schema(
        schema: 'User',
        description: 'Show information about user',
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
                property: 'email',
                type: 'string',
            ),
            new OA\Property(
                property: 'createdAt',
                type: 'string',
            ),

        ]
    )]
    public function toArray(Request $request): array
    {
        /** @var UserIterator $resource */
        $resource = $this->resource;

        return [
            'id'            => $resource->getId(),
            'firstName'     => $resource->getFirstName(),
            'lastName'      => $resource->getLastName(),
            'phoneNumber'   => $resource->getPhoneNumber(),
            'email'         => $resource->getEmail(),
            'createdAt'     => $resource->getCreatedAt(),
        ];
    }
}
