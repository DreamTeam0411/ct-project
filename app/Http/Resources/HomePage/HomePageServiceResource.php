<?php

namespace App\Http\Resources\HomePage;

use App\Repositories\Services\Iterators\TitlePageServiceIterator;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HomePageServiceResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var TitlePageServiceIterator $resource */
        $resource = $this->resource;

        return [
            'id'            => $resource->getId(),
            'title'         => $resource->getTitle(),
            'description'   => $resource->getDescription(),
            'rating'        => $resource->getRating(),
        ];
    }
}
