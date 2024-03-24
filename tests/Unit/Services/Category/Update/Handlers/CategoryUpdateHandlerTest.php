<?php

namespace Tests\Unit\Services\Category\Update\Handlers;

use AllowDynamicProperties;
use App\Repositories\Categories\CategoryRepository;
use App\Repositories\Categories\CategoryUpdateDTO;
use App\Repositories\Categories\Iterators\PrivateCategoryIterator;
use App\Services\Category\CategoryImageStorage;
use App\Services\Category\Update\Handlers\CategoryUpdateHandler;
use Illuminate\Http\UploadedFile;
use Mockery;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

#[AllowDynamicProperties]
class CategoryUpdateHandlerTest extends TestCase
{
    protected CategoryRepository $categoryRepository;
    protected CategoryImageStorage $categoryImageStorage;

    /**
     * @throws Exception
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->categoryRepository = $this->createMock(CategoryRepository::class);

        $this->handler = new CategoryUpdateHandler(
            $this->categoryRepository,
        );
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        Mockery::close();
    }


    /**
     * @throws Exception
     */
    public function testHandleWithImage(): void
    {
//        $DTO = new CategoryUpdateDTO(1, null, 'Title', null);
//
//        $this->categoryRepository
//            ->expects(self::once())
//            ->method('updatePrivateCategory')
//            ->with($DTO);
//
//        $result = $this->handler->handle($DTO, function ($DTO) {
//            return $DTO;
//        });
//
//        $this->assertSame($DTO, $result);
    }
}
