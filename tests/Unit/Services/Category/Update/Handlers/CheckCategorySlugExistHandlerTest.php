<?php

namespace Tests\Unit\Services\Category\Update\Handlers;

use App\Repositories\Categories\CategoryRepository;
use App\Repositories\Categories\CategoryUpdateDTO;
use App\Services\Category\Update\Handlers\CheckCategorySlugExistHandler;
use Exception;
use Illuminate\Support\Str;
use PHPUnit\Framework\TestCase;

class CheckCategorySlugExistHandlerTest extends TestCase
{
    protected CategoryRepository $categoryRepository;
    protected CheckCategorySlugExistHandler $handler;

    /**
     * @return void
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->categoryRepository = $this->createMock(CategoryRepository::class);

        $this->handler = new CheckCategorySlugExistHandler(
            $this->categoryRepository,
        );
    }

    /**
     * A basic unit test example.
     * @throws Exception
     */
    public function testHandleSlugExists(): void
    {
        $DTO = new CategoryUpdateDTO(1, 5, 'Title', null);

        $this->categoryRepository
            ->expects(self::once())
            ->method('isSlugExists')
            ->with(Str::slug($DTO->getTitle()), $DTO->getId())
            ->willReturn(true);

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('This category already exists');
        $this->expectExceptionCode(400);

        $this->handler->handle($DTO, function ($DTO) {
            return $DTO;
        });
    }

    /**
     * @dataProvider handleProvider
     * @throws Exception
     */
    public function testHandleSlugNotExists(array $data)
    {
        $DTO = new CategoryUpdateDTO(...$data);

        $this->categoryRepository
            ->expects(self::once())
            ->method('isSlugExists')
            ->with(Str::slug($DTO->getTitle()), $DTO->getId())
            ->willReturn(false);

        $result = $this->handler->handle($DTO, function ($DTO) {
            return $DTO;
        });

        $this->assertEquals($DTO, $result);
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
