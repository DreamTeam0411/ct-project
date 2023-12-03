<?php

namespace App\Repositories\HomePageAboutUsBlock;

use App\Repositories\HomePageAboutUsBlock\Iterators\HomePageAboutUsBlockIterator;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class HomePageAboutUsBlockRepository
{
    protected Builder $query;
    protected const LIMIT = 2;
    public function __construct()
    {
        $this->query = DB::table('home_page_about_us_block');
    }

    public function getAboutUsBlock(): Collection
    {
        $collection = $this->query->select([
            'title',
            'description',
            'image',
            ])
        ->take(self::LIMIT)
        ->get();

        return $collection->map(function ($block) {
            return new HomePageAboutUsBlockIterator($block);
        });
    }
}
