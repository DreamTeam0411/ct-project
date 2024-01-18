<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Service\ServiceIndexRequest;
use App\Http\Resources\Service\PublicServiceResource;
use App\Repositories\Services\ServiceIndexDTO;
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
    ) {
    }

    /**
     * @param ServiceIndexRequest $request
     * @return JsonResponse
     */
    #[OA\Get(
        path: '/v1/all-services',
        tags: ['Service'],
        parameters: [
            new OA\Parameter(
                name: 'category',
                in: 'query',
                schema: new OA\Schema(
                    type: 'string',
                    maxLength: 255,
                ),
            ),
            new OA\Parameter(
                name: 'city',
                in: 'query',
                schema: new OA\Schema(
                    type: 'string',
                    maxLength: 255,
                ),
            ),
        ],
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
        $validated = $request->validated();
        $DTO = new ServiceIndexDTO(...$validated);
        $service = $this->serviceService->getPublicServices($DTO);
        $resource = PublicServiceResource::collection($service);

        return $resource->response()->setStatusCode(200);
    }
}
