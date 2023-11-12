<?php

namespace App\Http\Resources\User;

use App\Repositories\UserRepository\Iterators\UserIterator;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
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
