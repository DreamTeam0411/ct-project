<?php

namespace App\Http\Resources\Category;

use App\Repositories\Categories\Iterators\PrivateSubcategoryIterator;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryNameAndSlugResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var PrivateSubcategoryIterator $resource */
        $resource = $this->resource;

        return [
            'title' => $resource->getTitle(),
            'slug'  => $resource->getSlug(),
        ];
    }
}
