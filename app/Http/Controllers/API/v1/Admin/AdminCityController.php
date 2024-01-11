<?php

namespace App\Http\Controllers\API\v1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\City\CityDestroyRequest;
use App\Http\Requests\City\CityIndexRequest;
use App\Http\Requests\City\CityShowRequest;
use App\Http\Requests\City\CityStoreRequest;
use App\Http\Requests\City\CityUpdateRequest;
use App\Http\Resources\City\CityResource;
use App\Repositories\Cities\CityStoreDTO;
use App\Repositories\Cities\CityUpdateDTO;
use App\Services\City\CityService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use OpenApi\Attributes as OA;

class AdminCityController extends Controller
{
    public function __construct(
        protected CityService $cityService,
    ) {
    }

    /**
     * @param CityIndexRequest $request
     * @return JsonResponse
     */
    #[OA\Get(
        path: '/v1/admin/cities',
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
                description: 'Show all cities',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(
                            property: 'data',
                            ref: '#/components/schemas/City',
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
    public function index(CityIndexRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $service = $this->cityService->getAllCitiesByLastId($validated['lastId']);
        $resource = CityResource::collection($service);

        return $resource->response()->setStatusCode(200);
    }

    /**
     * @param CityStoreRequest $request
     * @return JsonResponse
     */
    #[OA\Post(
        path: '/v1/admin/cities',
        security: [['bearerAuth' => []]],
        tags: ['Admin Panel'],
        parameters: [
            new OA\Parameter(
                name: 'countryId',
                description: 'Country ID',
                in: 'query',
                required: true,
                schema: new OA\Schema(
                    type: 'integer',
                ),
            ),
            new OA\Parameter(
                name: 'parentId',
                description: 'Parent Category ID',
                in: 'query',
                schema: new OA\Schema(
                    type: 'integer',
                    nullable: true,
                ),
            ),
            new OA\Parameter(
               name: 'name',
                description: 'Name of the city',
               in: 'query',
               required: true,
               schema: new OA\Schema(
                   type: 'string',
               ),
            ),
        ],
        responses: [
            new OA\Response(
                response: 201,
                description: 'Created city',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(
                            property: 'data',
                            ref: '#/components/schemas/City',
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
    public function store(CityStoreRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $DTO = new CityStoreDTO(...$validated);
        $service = $this->cityService->insertAndGetCity($DTO);
        $resource = new CityResource($service);

        return $resource->response()->setStatusCode(201);
    }

    /**
     * @param CityShowRequest $request
     * @return JsonResponse
     */
    #[OA\Get(
        path: '/v1/admin/cities/{id}',
        security: [['bearerAuth' => []]],
        tags: ['Admin Panel'],
        parameters: [
            new OA\Parameter(
                name: 'id',
                description: 'City ID',
                in: 'path',
                required: true,
                schema: new OA\Schema(
                    type: 'integer',
                ),
            ),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Show information about the city',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(
                            property: 'data',
                            ref: '#/components/schemas/City',
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
    public function show(CityShowRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $service = $this->cityService->getById($validated['id']);
        $resource = new CityResource($service);

        return $resource->response()->setStatusCode(200);
    }

    /**
     * @param CityUpdateRequest $request
     * @return JsonResponse
     */
    #[OA\Patch(
        path: '/v1/admin/cities/{id}',
        security: [['bearerAuth' => []]],
        tags: ['Admin Panel'],
        parameters: [
            new OA\Parameter(
                name: 'id',
                description: 'City ID',
                in: 'path',
                required: true,
                schema: new OA\Schema(
                    type: 'integer',
                ),
            ),
            new OA\Parameter(
                name: 'countryId',
                description: 'Country ID',
                in: 'query',
                required: true,
                schema: new OA\Schema(
                    type: 'integer',
                ),
            ),
            new OA\Parameter(
                name: 'parentId',
                description: 'Parent Category ID',
                in: 'query',
                schema: new OA\Schema(
                    type: 'integer',
                    nullable: true,
                ),
            ),
            new OA\Parameter(
                name: 'name',
                description: 'Name of the city',
                in: 'query',
                required: true,
                schema: new OA\Schema(
                    type: 'string',
                ),
            ),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Show information about updated city',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(
                            property: 'data',
                            ref: '#/components/schemas/City',
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
    public function update(CityUpdateRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $DTO = new CityUpdateDTO(...$validated);
        $service = $this->cityService->update($DTO);
        $resource = new CityResource($service);

        return $resource->response()->setStatusCode(200);
    }

    /**
     * @param CityDestroyRequest $request
     * @return Response
     */
    #[OA\Delete(
        path: '/v1/admin/cities/{id}',
        security: [['bearerAuth' => []]],
        tags: ['Admin Panel'],
        parameters: [
            new OA\Parameter(
                name: 'id',
                description: 'City ID',
                in: 'path',
                required: true,
                schema: new OA\Schema(
                    type: 'integer',
                ),
            ),
        ],
        responses: [
            new OA\Response(
                response: 204,
                description: 'The city has been deleted',
            ),
            new OA\Response(
                response: 422,
                description: 'Validation errors',
                content: new OA\JsonContent(
                    ref: '#/components/schemas/ValidationErrors'
                )
            ),
        ],
    )]
    public function destroy(CityDestroyRequest $request): Response
    {
        $validated = $request->validated();
        $this->cityService->delete($validated['id']);

        return response()->noContent();
    }
}
