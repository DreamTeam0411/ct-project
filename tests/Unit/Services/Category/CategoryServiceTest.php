<?php

namespace Tests\Unit\Services\Category;

use App\Repositories\Categories\CategoryRepository;
use App\Repositories\Services\ServiceRepository;
use App\Services\Category\CategoryImageStorage;
use App\Services\Category\CategoryService;
use Illuminate\Support\Collection;
use Mockery;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

class CategoryServiceTest extends TestCase
{
    protected CategoryRepository $categoryRepository;
    protected ServiceRepository $serviceRepository;
    protected CategoryImageStorage $categoryImageStorage;
    protected CategoryService $categoryService;

    /**
     * @throws Exception
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->categoryRepository = $this->createMock(CategoryRepository::class);
        $this->serviceRepository = $this->createMock(ServiceRepository::class);
        $this->categoryImageStorage = $this->createMock(CategoryImageStorage::class);

        $this->categoryService = new CategoryService(
            $this->categoryRepository,
            $this->serviceRepository,
            $this->categoryImageStorage,
        );
    }

    /**
     * @return void
     */
    protected function tearDown(): void
    {
        parent::tearDown();
        Mockery::close();
    }

    /**
     * @return void
     */
    public function testGetAllPrivateCategories(): void
    {
        $id = 1;

        $expectedCategories = new Collection([]);

        $this->categoryRepository
            ->expects(self::once())
            ->method('getAllPrivateCategories')
            ->with($id)
            ->willReturn(
                $expectedCategories
            );

        $result = $this->categoryService->getAllPrivateCategories($id);

        $this->assertInstanceOf(Collection::class, $result);
        $this->assertEquals($expectedCategories, $result);
    }

    /**
     * @return void
     */
    public function testGetAllPublicCategories(): void
    {
        $expectedCategories = new Collection([]);

        $this->categoryRepository
            ->expects(self::once())
            ->method('getAllPublicCategories')
            ->willReturn(
                $expectedCategories
            );

        $result = $this->categoryService->getAllPublicCategories();

        $this->assertInstanceOf(Collection::class, $result);
        $this->assertEquals($expectedCategories, $result);
    }

    
}
