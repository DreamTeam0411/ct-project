<?php

namespace App\Http\Resources\User;

use App\Repositories\UserRepository\Iterators\AdminBusinessIterator;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

class AdminBusinessResource extends JsonResource
{
    /**
     * @param Request $request
     * @return array
     */
    #[OA\Schema(
        schema: 'AdminBusiness',
        description: 'Show information about user with business role in admin panel',
        properties: [
            new OA\Property(
                property: 'id',
                type: 'integer',
            ),
            new OA\Property(
                property: 'username',
                type: 'string',
            ),
            new OA\Property(
                property: 'service',
                type: 'string',
            ),
            new OA\Property(
                property: 'email',
                type: 'string',
            ),
            new OA\Property(
                property: 'address',
                type: 'string',
                nullable: true,
            ),
            new OA\Property(
                property: 'phoneNumber',
                type: 'string',
            ),
        ]
    )]
    public function toArray(Request $request): array
    {
        /** @var AdminBusinessIterator $resource */
        $resource = $this->resource;

        return [
            'id'            => $resource->getId(),
            'username'      => $resource->getLastName() . ' ' . $resource->getFirstName(),
            'service'       => $resource->getService() ?? '',
            'email'         => $resource->getEmail(),
            'address'       => $resource->getAddress() ?? '',
            'phoneNumber'   => $resource->getPhoneNumber(),
        ];
    }
}
