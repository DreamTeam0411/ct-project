<?php

namespace App\Http\Resources\Password;

use App\Services\Password\PasswordResetDTO;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

class ResetPasswordResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    #[OA\Schema(
        schema: 'ResetPassword',
        description: 'Show email and generated reset token',
        properties: [
            new OA\Property(
                property: 'email',
                type: 'string',
            ),
            new OA\Property(
                property: 'token',
                type: 'string',
            ),
        ],
    )]
    public function toArray(Request $request): array
    {
        /** @var PasswordResetDTO $resource */
        $resource = $this->resource;

        return [
            'email' => $resource->getEmail(),
            'token' => $resource->getToken(),
        ];
    }
}
