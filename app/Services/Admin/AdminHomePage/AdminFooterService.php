<?php

namespace App\Services\Admin\AdminHomePage;

use App\Repositories\HomePageFooter\HomePageFooterBlockRepository;
use App\Repositories\HomePageFooter\HomePageFooterBlockUpdateDTO;
use App\Repositories\HomePageFooter\Iterators\HomePageFooterBlockIterator;

class AdminFooterService
{
    public function __construct(
        protected HomePageFooterBlockRepository $footerBlockRepository,
    ){
    }

    /**
     * @param HomePageFooterBlockUpdateDTO $DTO
     * @return HomePageFooterBlockIterator
     */
    public function footerUpdate(HomePageFooterBlockUpdateDTO $DTO): HomePageFooterBlockIterator
    {
        $this->footerBlockRepository->updateTitlePageFooter($DTO);

        return $this->footerBlockRepository->getTitlePageFooter();
    }
}
