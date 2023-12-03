<?php

namespace App\Repositories\HomePageLinks;

use App\Repositories\HomePageLinks\Iterators\HomePageLinksIterator;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class HomePageLinksRepository
{
    protected Builder $query;

    public function __construct()
    {
        $this->query = DB::table('home_page_links');
    }

    public function getTitlesAndLinks(): Collection
    {
        $collection = $this->query->select([
            'title',
            'link',
        ])->get();

        return $collection->map(function ($data) {
            return new HomePageLinksIterator($data);
        });
    }
}
