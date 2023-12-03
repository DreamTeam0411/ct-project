<?php

namespace App\Repositories\Categories\Iterators;

use ArrayIterator;
use Illuminate\Support\Collection;
use IteratorAggregate;

class HomePageSubcategoryIterator implements IteratorAggregate
{
    protected array $data = [];

    public function __construct(Collection $collection)
    {
        foreach ($collection as $item) {
            $this->data[] = new PublicSubcategoryIterator($item);
        }
    }

    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->data);
    }

    public function getResource(): array
    {
        /** @var PublicSubcategoryIterator $subcategory */
        return array_map(fn($subcategory) => [
            'title' => $subcategory->getTitle(),
            'slug'  => $subcategory->getSlug(),
        ], $this->data);
    }
}
