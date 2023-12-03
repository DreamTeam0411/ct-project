<?php

namespace App\Repositories\Categories;

use App\Repositories\Categories\Iterators\HomePageCategoryCollectionIterator;
use App\Repositories\Categories\Iterators\HomePageCategoryIterator;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

class CategoryRepository
{
    protected Builder $query;

    public function __construct()
    {
        $this->query = DB::table('categories');
    }

    public function getHomePageCategories(): HomePageCategoryCollectionIterator
    {
        $collection = $this->query->select([
            'id',
            'parent_id',
            'icon',
            'title',
            'slug',
        ])->take(48)->get();

        return new HomePageCategoryCollectionIterator($collection);
    }
}
