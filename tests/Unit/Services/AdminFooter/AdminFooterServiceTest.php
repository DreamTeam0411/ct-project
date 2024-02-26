<?php

namespace Tests\Unit\Services\AdminFooter;

use App\Repositories\HomePageFooter\HomePageFooterBlockRepository;
use App\Repositories\HomePageFooter\HomePageFooterBlockUpdateDTO;
use App\Repositories\HomePageFooter\Iterators\HomePageFooterBlockIterator;
use App\Services\Admin\AdminHomePage\AdminFooterService;
use Mockery;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

class AdminFooterServiceTest extends TestCase
{
    protected HomePageFooterBlockRepository $footerBlockRepository;
    protected AdminFooterService $service;

    /**
     * @throws Exception
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->footerBlockRepository = $this->createMock(HomePageFooterBlockRepository::class);

        $this->service = new AdminFooterService(
            $this->footerBlockRepository
        );
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        Mockery::close();
    }

    /**
     * @dataProvider footerUpdateProvider
     */
    public function testFooterUpdate(array $data): void
    {
        $DTO = new HomePageFooterBlockUpdateDTO(...$data);

        $expectedResult = new HomePageFooterBlockIterator((object)[
            'description'           => $data['description'],
            'privacy_policy_link'   => $data['privacyPolicyLink'],
            'terms_and_condition'   => $data['termsAndCondition'],
        ]);

        $this->footerBlockRepository
            ->expects(self::once())
            ->method('updateTitlePageFooter')
            ->with($DTO);

        $this->footerBlockRepository
            ->expects(self::once())
            ->method('getTitlePageFooter')
            ->willReturn($expectedResult);

        $result = $this->service->footerUpdate($DTO);

        $this->assertEquals($expectedResult, $result);
    }

    /**
     * @return array[]
     */
    public static function footerUpdateProvider(): array
    {
        return [
            'validData' => [
                'data' => [
                    'description'       => 'lorem ipsum',
                    'privacyPolicyLink' => '',
                    'termsAndCondition' => '',
                ],
            ],
        ];
    }
}
