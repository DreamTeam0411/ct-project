<?php

namespace App\Services\HomePage;

use App\Repositories\Categories\CategoryRepository;
use App\Repositories\HomePageAboutUsBlock\HomePageAboutUsBlockRepository;
use App\Repositories\HomePageFooter\HomePageFooterBlockRepository;
use App\Repositories\HomePageHeaderBlock\HomePageHeaderBlockRepository;
use App\Repositories\HomePageCategories\HomePageCategoriesBlockRepository;
use App\Repositories\HomePageLinks\HomePageLinksRepository;
use App\Repositories\HomePageLogo\HomePageLogoRepository;
use App\Repositories\SocialMediaNetwork\SocialMediaNetworkRepository;
use App\Services\HomePage\Iterators\HomePageIterator;

class HomePageService
{
    public function __construct(
        protected HomePageLogoRepository            $logoRepository,
        protected HomePageLinksRepository           $linksRepository,
        protected HomePageHeaderBlockRepository     $headerBlockRepository,
        protected HomePageCategoriesBlockRepository $categoriesBlockRepository,
        protected CategoryRepository                $categoryRepository,
        protected HomePageAboutUsBlockRepository    $aboutUsBlockRepository,
        protected HomePageFooterBlockRepository     $footerRepository,
        protected SocialMediaNetworkRepository      $socialMediaRepository,
        protected HomePageStorage                   $storage,
    ) {
    }

    public function index(): HomePageIterator
    {
        $cachedData = $this->storage->get();

        if ($cachedData === null) {
            $query = new HomePageIterator((object)[
                'logo'                  => $this->logoRepository->getLogo()->getLogo(),
                'links'                 => $this->linksRepository->getTitlesAndLinks(),
                'header'                => $this->headerBlockRepository->getInfo(),
                'categoriesBlock'       => $this->categoriesBlockRepository->getCategoriesBlock(),
                'categoriesContent'     => $this->categoryRepository->getHomePageCategories(),
                'aboutUsBlock'          => $this->aboutUsBlockRepository->getAboutUsBlock(),
                'footerBlock'           => $this->footerRepository->getTitlePageFooter(),
                'socialMedia'           => $this->socialMediaRepository->getHomePageSocialMediaNetworks(),
            ]);

            $this->storage->set($query);
            return $query;
        }

        return $cachedData;
    }
}
