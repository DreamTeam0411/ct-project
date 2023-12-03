<?php

namespace App\Repositories\HomePageLogo;

use App\Repositories\HomePageLogo\Iterators\HomePageLogoIterator;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

class HomePageLogoRepository
{
    protected Builder $query;
    protected const ID = 1;

    public function __construct()
    {
        $this->query = DB::table('home_page_logo');
    }

    /**
     * @return HomePageLogoIterator
     */
    public function getLogo(): HomePageLogoIterator
    {
        $result = $this->query
            ->select('logo')
            ->where('id', '=', self::ID)
            ->first();

        return new HomePageLogoIterator($result);
    }
}
