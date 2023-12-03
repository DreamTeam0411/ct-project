<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\HomePage\HomePageResource;
use App\Services\HomePage\HomePageService;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;

class HomePageController extends Controller
{
    public function __construct(
        protected HomePageService $mainPageService,
    ) {
    }

    /**
     * @return JsonResponse
     */
    #[OA\Get(
        path: '/v1/homepage',
        tags: ['Homepage'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Homepage response',
                content: new OA\JsonContent(
                    ref: '#/components/schemas/Homepage'
                ),
            ),
        ]
    )]
    public function index(): JsonResponse
    {
        $service = $this->mainPageService->index();
        $resource = new HomePageResource($service);

        return $resource->response()->setStatusCode(200);
    }
}
