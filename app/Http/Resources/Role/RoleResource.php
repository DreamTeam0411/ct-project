<?php

namespace App\Http\Resources\Role;

use App\Repositories\RoleUser\Iterators\RoleIterator;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

class RoleResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    #[OA\Schema(
        schema: 'Role',
        description: 'Show information about the role(s)',
        properties: [
            new OA\Property(
                property: 'id',
                type: 'integer',
            ),
            new OA\Property(
                property: 'name',
                type: 'string',
            ),
        ]
    )]
    public function toArray(Request $request): array
    {
        /** @var RoleIterator $resource */
        $resource = $this->resource;

        return [
            'id'    => $resource->getId(),
            'name'  => $resource->getName(),
        ];
    }
}
