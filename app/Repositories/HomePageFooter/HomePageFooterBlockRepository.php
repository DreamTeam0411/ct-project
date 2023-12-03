<?php

namespace App\Repositories\HomePageFooter;

use App\Repositories\HomePageFooter\Iterators\HomePageFooterBlockIterator;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

class HomePageFooterBlockRepository
{
    protected Builder $query;
    private const ID = 1;

    public function __construct()
    {
        $this->query = DB::table('home_page_footer_block');
    }

    public function getTitlePageFooter(): HomePageFooterBlockIterator
    {
        return new HomePageFooterBlockIterator(
            $this->query->select('description')
                ->where('id', '=', self::ID)
                ->first()
        );
    }
}
