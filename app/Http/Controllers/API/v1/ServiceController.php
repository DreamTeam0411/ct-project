<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Service\ServiceDestroyRequest;
use App\Http\Requests\Service\ServiceIndexRequest;
use App\Http\Requests\Service\ServiceShowRequest;
use App\Http\Requests\Service\ServiceStoreRequest;
use App\Http\Requests\Service\ServiceUpdateRequest;
use App\Http\Resources\Service\ServiceResource;
use App\Repositories\Services\ServiceStoreDTO;
use App\Repositories\Services\ServiceUpdateDTO;
use App\Services\Service\ServiceService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use OpenApi\Attributes as OA;

class ServiceController extends Controller
{
    /**
     * @param ServiceService $service
     */
    public function __construct(
        protected ServiceService $service,
    ) {
    }

    /**
     * @param ServiceIndexRequest $request
     * @return JsonResponse
     */
    #[OA\Get(
        path: '/v1/admin/services',
        security: [['bearerAuth' => []]],
        tags: ['Admin Panel'],
        parameters: [
            new OA\Parameter(
                name: 'lastId',
                description: 'Min: 0',
                in: 'query',
                schema: new OA\Schema(
                    type: 'integer',
                    minimum: 0,
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
                            ref: '#/components/schemas/Service',
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
        $service = $this->service->getPrivateServices($validated['lastId']);
        $resource = ServiceResource::collection($service);

        return $resource->response()->setStatusCode(200);
    }

    /**
     * @param ServiceStoreRequest $request
     * @return JsonResponse
     */
    #[OA\Post(
        path: '/v1/admin/services',
        security: [['bearerAuth' => []]],
        tags: ['Admin Panel'],
        parameters: [
            new OA\Parameter(
                name: 'categoryId',
                description: 'Only existing Category ID',
                in: 'query',
                required: true,
                schema: new OA\Schema(
                    type: 'integer',
                    minimum: 1,
                ),
            ),
            new OA\Parameter(
                name: 'title',
                description: 'max: 255',
                in: 'query',
                required: true,
                schema: new OA\Schema(
                    type: 'string',
                    maxLength: 255,
                ),
            ),
            new OA\Parameter(
                name: 'description',
                description: 'max: 500',
                in: 'query',
                required: true,
                schema: new OA\Schema(
                    type: 'string',
                    maxLength: 500,
                ),
            ),
            new OA\Parameter(
                name: 'price',
                description: 'regex in format: 999.99',
                in: 'query',
                required: true,
                schema: new OA\Schema(
                    type: 'number',
                    format: 'double',
                ),
            ),
            new OA\Parameter(
                name: 'cityId',
                description: 'Only existing City ID',
                in: 'query',
                required: true,
                schema: new OA\Schema(
                    type: 'integer',
                    minimum: 1,
                ),
            ),
        ],
        responses: [
            new OA\Response(
                response: 201,
                description: 'Create new service',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(
                            property: 'data',
                            ref: '#/components/schemas/Service',
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
    public function store(ServiceStoreRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $DTO = new ServiceStoreDTO(...$validated);
        $service = $this->service->insertAndGetService($DTO);
        $resource = new ServiceResource($service);

        return $resource->response()->setStatusCode(201);
    }

    /**
     * @param ServiceShowRequest $request
     * @return JsonResponse
     */
    #[OA\Get(
        path: '/v1/admin/services/{id}',
        security: [['bearerAuth' => []]],
        tags: ['Admin Panel'],
        parameters: [
            new OA\Parameter(
                name: 'id',
                in: 'path',
                required: true,
                schema: new OA\Schema(
                    type: 'integer',
                    minimum: 1,
                ),
            ),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Show the service',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(
                            property: 'data',
                            ref: '#/components/schemas/Service',
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
    public function show(ServiceShowRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $service = $this->service->getById($validated['id']);
        $resource = new ServiceResource($service);

        return $resource->response()->setStatusCode(200);
    }

    /**
     * @param ServiceUpdateRequest $request
     * @return JsonResponse
     */
    #[OA\Patch(
        path: '/v1/admin/services/{id}',
        security: [['bearerAuth' => []]],
        tags: ['Admin Panel'],
        parameters: [
            new OA\Parameter(
                name: 'id',
                in: 'path',
                required: true,
                schema: new OA\Schema(
                    type: 'integer',
                    minimum: 1,
                ),
            ),
            new OA\Parameter(
                name: 'categoryId',
                description: 'Only existing Category ID',
                in: 'query',
                required: true,
                schema: new OA\Schema(
                    type: 'integer',
                    minimum: 1,
                ),
            ),
            new OA\Parameter(
                name: 'title',
                description: 'max: 255',
                in: 'query',
                required: true,
                schema: new OA\Schema(
                    type: 'string',
                    maxLength: 255,
                ),
            ),
            new OA\Parameter(
                name: 'description',
                description: 'max: 500',
                in: 'query',
                required: true,
                schema: new OA\Schema(
                    type: 'string',
                    maxLength: 500,
                ),
            ),
            new OA\Parameter(
                name: 'price',
                description: 'regex in format: 999.99',
                in: 'query',
                required: true,
                schema: new OA\Schema(
                    type: 'number',
                    format: 'double',
                ),
            ),
            new OA\Parameter(
                name: 'cityId',
                description: 'Only existing City ID',
                in: 'query',
                required: true,
                schema: new OA\Schema(
                    type: 'integer',
                    minimum: 1,
                ),
            ),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Show updated service',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(
                            property: 'data',
                            ref: '#/components/schemas/Service',
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
    public function update(ServiceUpdateRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $DTO = new ServiceUpdateDTO(...$validated);
        $service = $this->service->updateAndGetById($DTO);
        $resource = new ServiceResource($service);

        return $resource->response()->setStatusCode(200);
    }

    /**
     * @param ServiceDestroyRequest $request
     * @return Response
     */
    #[OA\Delete(
        path: '/v1/admin/services/{id}',
        security: [['bearerAuth' => []]],
        tags: ['Admin Panel'],
        parameters: [
            new OA\Parameter(
                name: 'id',
                in: 'path',
                required: true,
                schema: new OA\Schema(
                    type: 'integer',
                    minimum: 1,
                ),
            ),
        ],
        responses: [
            new OA\Response(
                response: 204,
                description: 'Delete the service',
            ),
        ],
    )]
    public function destroy(ServiceDestroyRequest $request): Response
    {
        $validated = $request->validated();
        $this->service->deleteById($validated['id']);

        return response()->noContent();
    }
}
