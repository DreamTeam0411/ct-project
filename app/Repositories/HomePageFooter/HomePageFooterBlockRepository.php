<?php

namespace App\Repositories\HomePageFooter;

use App\Repositories\HomePageFooter\Iterators\HomePageFooterBlockIterator;
use Carbon\Carbon;
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

    /**
     * @return HomePageFooterBlockIterator
     */
    public function getTitlePageFooter(): HomePageFooterBlockIterator
    {
        return new HomePageFooterBlockIterator(
            $this->query
                ->select([
                    'home_page_footer_block.description',
                    'home_page_footer_block.privacy_policy_link',
                    'home_page_footer_block.terms_and_condition',
                ])
                ->where('id', '=', self::ID)
                ->first()
        );
    }

    /**
     * @param HomePageFooterBlockUpdateDTO $DTO
     * @return void
     */
    public function updateTitlePageFooter(HomePageFooterBlockUpdateDTO $DTO): void
    {
        $this->query
            ->where('home_page_footer_block.id', '=', self::ID)
            ->update([
                'description'           => $DTO->getDescription(),
                'privacy_policy_link'   => $DTO->getPrivacyPolicyLink(),
                'terms_and_condition'   => $DTO->getTermsAndCondition(),
                'updated_at'            => Carbon::now(),
            ]);
    }
}
