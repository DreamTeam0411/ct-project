<?php

namespace App\Repositories\HomePageCategories;

use App\Repositories\HomePageCategories\Iterators\HomePageCategoriesBlockIterator;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

class HomePageCategoriesBlockRepository
{
    protected Builder $query;
    protected const ID = 1;
    public function __construct()
    {
        $this->query = DB::table('home_page_categories_block');
    }

    public function getCategoriesBlock(): HomePageCategoriesBlockIterator
    {
        return new HomePageCategoriesBlockIterator(
            $this->query->select('title', 'description')
                ->where('id', '=', self::ID)
                ->first()
        );
    }
}
