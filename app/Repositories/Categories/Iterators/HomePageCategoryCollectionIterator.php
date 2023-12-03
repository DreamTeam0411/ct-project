<?php

namespace App\Repositories\Categories\Iterators;

use ArrayIterator;
use Exception;
use Illuminate\Support\Collection;
use IteratorAggregate;

class HomePageCategoryCollectionIterator implements IteratorAggregate
{
    protected array $data;

    public function __construct(Collection $collection)
    {
        $tmpData = [];
        foreach ($collection as $key => $item) {
            if (is_null($item->parent_id) === true) {
                $tmpData[$key] = $item;
                $tmpData[$key]->subcategories = collect();
            }
        }

        foreach ($tmpData as $tempItem) {
            foreach ($collection as $item) {
                if (is_null($item->parent_id) === false && $tempItem->id === $item->parent_id) {
                    $tempItem->subcategories->push((object)[
                        'title' => $item->title,
                        'slug'  => $item->slug,
                    ]);
                }
            }
        }

        foreach ($tmpData as $dataItem) {
            $this->data[] = new HomePageCategoryIterator((object)[
                'title'         => $dataItem->title,
                'slug'          => $dataItem->slug,
                'icon'          => $dataItem->icon,
                'subcategories' => $dataItem->subcategories
            ]);
        }

    }

    /**
     * @return ArrayIterator
     */
    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->data);
    }
}
