<?php

namespace App\Http\Controllers\API\v1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminHomePage\FooterUpdateRequest;
use App\Http\Resources\HomePage\HomePageFooterBlockResource;
use App\Repositories\HomePageFooter\HomePageFooterBlockUpdateDTO;
use App\Services\Admin\AdminHomePage\AdminFooterService;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;

class AdminHomePageController extends Controller
{
    public function __construct(
        protected AdminFooterService $adminFooterService,
    ) {
    }

    /**
     * @param FooterUpdateRequest $request
     * @return JsonResponse
     */
    #[OA\Patch(
        path: '/v1/admin/homepage/footer-update',
        security: [['bearerAuth' => []]],
        tags: ['Admin Panel'],
        parameters: [
            new OA\Parameter(
                name: 'description',
                in: 'query',
                schema: new OA\Schema(
                    type: 'string',
                    maxLength: 255,
                )
            ),
            new OA\Parameter(
                name: 'privacyPolicyLink',
                in: 'query',
                schema: new OA\Schema(
                    type: 'string',
                    maxLength: 255,
                    nullable: true,
                )
            ),
            new OA\Parameter(
                name: 'termsAndCondition',
                in: 'query',
                schema: new OA\Schema(
                    type: 'string',
                    maxLength: 255,
                    nullable: true,
                )
            ),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Show updated footer info',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(
                            property: 'data',
                            ref: '#/components/schemas/Footer',
                        ),
                    ],
                ),
            ),
            new OA\Response(
                response: 422,
                description: 'Validation errors',
                content: new OA\JsonContent(
                    ref: '#/components/schemas/ValidationErrors',
                ),
            ),
        ]
    )]
    public function footerUpdate(FooterUpdateRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $DTO = new HomePageFooterBlockUpdateDTO(...$validated);
        $service = $this->adminFooterService->footerUpdate($DTO);
        $resource = new HomePageFooterBlockResource($service);

        return $resource->response()->setStatusCode(200);
    }
}
