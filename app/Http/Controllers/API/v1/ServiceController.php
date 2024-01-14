<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Service\ServiceIndexRequest;
use App\Http\Resources\Service\PublicServiceResource;
use App\Services\Service\ServiceService;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;

class ServiceController extends Controller
{
    /**
     * @param ServiceService $serviceService
     */
    public function __construct(
        protected ServiceService $serviceService,
    ){
    }

    /**
     * @param ServiceIndexRequest $request
     * @return JsonResponse
     */
    #[OA\Get(
        path: '/v1/all-services',
        tags: ['Service'],
        parameters: [],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Show all services',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(
                            property: 'data',
                            ref: '#/components/schemas/PublicService',
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
        ],
    )]
    public function index(ServiceIndexRequest $request): JsonResponse
    {
//        $validated = $request->validated();
        $service = $this->serviceService->getPublicServices();
        $resource = PublicServiceResource::collection($service);

        return $resource->response()->setStatusCode(200);
    }
}
