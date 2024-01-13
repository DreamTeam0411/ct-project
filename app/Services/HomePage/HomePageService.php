<?php

namespace App\Services\HomePage;

use App\Services\HomePage\Handlers\AboutUsBlockHandler;
use App\Services\HomePage\Handlers\CategoriesBlockHandler;
use App\Services\HomePage\Handlers\CategoriesContentHandler;
use App\Services\HomePage\Handlers\FooterBlockHandler;
use App\Services\HomePage\Handlers\HeaderHandler;
use App\Services\HomePage\Handlers\LinksHandler;
use App\Services\HomePage\Handlers\LogoHandler;
use App\Services\HomePage\Handlers\SocialMediaHandler;
use App\Services\HomePage\Iterators\HomePageIterator;
use Illuminate\Pipeline\Pipeline;

class HomePageService
{
    protected const HANDLERS = [
        LogoHandler::class,
        LinksHandler::class,
        HeaderHandler::class,
        CategoriesBlockHandler::class,
        CategoriesContentHandler::class,
        AboutUsBlockHandler::class,
        FooterBlockHandler::class,
        SocialMediaHandler::class,
    ];

    public function __construct(
        protected Pipeline $pipeline,
        protected HomePageStorage $storage,
    ) {
    }

    public function index(HomePageDTO $DTO): HomePageIterator
    {
        $cachedData = $this->storage->get();

        if ($cachedData === null) {
            /** @var HomePageDTO $finalDTO */
            $finalDTO = $this->pipeline
                ->send($DTO)
                ->through(self::HANDLERS)
                ->then(function (HomePageDTO $DTO) {
                    return $DTO;
                });

            $query = new HomePageIterator((object)[
                'logo'                  => $finalDTO->getLogo(),
                'links'                 => $finalDTO->getLinks(),
                'header'                => $finalDTO->getHeader(),
                'categoriesBlock'       => $finalDTO->getCategoriesBlock(),
                'categoriesContent'     => $finalDTO->getCategoriesContent(),
                'aboutUsBlock'          => $finalDTO->getAboutUsBlock(),
                'footerBlock'           => $finalDTO->getFooterBlock(),
                'socialMedia'           => $finalDTO->getSocialMedia(),
            ]);

            $this->storage->set($query);
            return $query;
        }

        return $cachedData;
    }
}
