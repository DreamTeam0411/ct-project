<?php

namespace App\Http\Resources;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ErrorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var Exception $resource */
        $resource = $this->resource;

        return [
            'message'   => $resource->getMessage(),
            'code'      => $resource->getCode(),
        ];
    }
}
