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
    protected UploadedFile $icon;

    /**
     * @throws Exception
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->categoryRepository = $this->createMock(CategoryRepository::class);
        $this->categoryImageStorage = $this->createMock(CategoryImageStorage::class);
        $this->iconMock = $this->createMock(UploadedFile::class);

        $this->handler = new CategoryUpdateHandler(
            $this->categoryRepository,
            $this->categoryImageStorage,
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
        $icon = $this->iconMock;

        $DTO = new CategoryUpdateDTO(1, null, 'Title', $icon);

        $iterator = new PrivateCategoryIterator((object)[
            'id' => 1,
            'parent_id' => null,
            'icon' => $icon,
            'title' => 'Title',
            'slug' => 'title',
            'createdBy' => (object)[
                'id'        => 1,
                'firstName' => 'John',
                'lastName'  => 'Doe',
                'email'     => 'john.doe@example.com',
            ],
            'updatedBy' => (object)[
                'id'        => 1,
                'firstName' => 'John',
                'lastName'  => 'Doe',
                'email'     => 'john.doe@example.com',
            ],
            'createdAt' => '2024-01-19 21:20:30',
            'updatedAt' => '2024-01-19 21:20:30',
        ]);

        $this->categoryRepository
            ->expects(self::once())
            ->method('updatePrivateCategory')
            ->with($DTO);

        $this->categoryRepository
            ->expects(self::once())
            ->method('getPrivateCategoryById')
            ->with($DTO->getId())
            ->willReturn($iterator);

        $this->categoryImageStorage
            ->expects(self::once())
            ->method('isImageExists')
            ->with($DTO->getIcon())
            ->willReturn(true);

        $this->categoryImageStorage
            ->expects(self::once())
            ->method('deleteImage')
            ->with($DTO->getIcon());

        $this->categoryImageStorage
            ->expects(self::once())
            ->method('saveImage')
            ->with($DTO->getIcon());

        $this->categoryRepository
            ->expects(self::once())
            ->method('updateImage')
            ->with($DTO);

        $result = $this->handler->handle($DTO, function ($DTO) {
            return $DTO;
        });

        $this->assertSame($DTO, $result);
    }

    /**
     * @dataProvider handleProvider
     */
    public function testHandleWithoutImage(array $data)
    {
        $DTO = new CategoryUpdateDTO(...$data);

        $this->categoryRepository
            ->expects(self::once())
            ->method('updatePrivateCategory')
            ->with($DTO);

        $this->categoryRepository
            ->expects(self::never())
            ->method('getPrivateCategoryById');

        $this->categoryImageStorage
            ->expects(self::never())
            ->method('isImageExists');

        $this->categoryImageStorage
            ->expects(self::never())
            ->method('deleteImage');

        $this->categoryImageStorage
            ->expects(self::never())
            ->method('saveImage')
            ->with($DTO->getIcon());

        $this->categoryRepository
            ->expects(self::never())
            ->method('updateImage')
            ->with($DTO);

        $result = $this->handler->handle($DTO, function ($DTO) {
            return $DTO;
        });

        $this->assertEquals($result, $DTO);
    }

    /**
     * @return array[]
     */
    public static function handleProvider(): array
    {
        return [
            'parentIdAndIconNull' => [
                'data' => [
                    'id'        => 1,
                    'parentId'  => null,
                    'title'     => 'Title',
                    'icon'      => null,
                ],
            ],
            'onlyIconNull' => [
                'data' => [
                    'id'        => 1,
                    'parentId'  => 5,
                    'title'     => 'Title',
                    'icon'      => null,
                ],
            ],
        ];
    }
}
