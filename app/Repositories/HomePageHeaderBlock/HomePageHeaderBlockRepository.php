<?php

namespace App\Repositories\HomePageHeaderBlock;

use App\Repositories\HomePageHeaderBlock\Iterators\HomePageHeaderBlockIterator;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

class HomePageHeaderBlockRepository
{
    protected Builder $query;
    protected const ID = 1;

    public function __construct()
    {
        $this->query = DB::table('home_page_header_block');
    }

    public function getInfo(): HomePageHeaderBlockIterator
    {
        $result = $this->query->select(['title', 'description'])
            ->where('id', '=', self::ID)
            ->first();

        return new HomePageHeaderBlockIterator($result);
    }
}
