<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Category\CategoryDestroyRequest;
use App\Http\Requests\Category\CategoryIndexRequest;
use App\Http\Requests\Category\CategoryShowRequest;
use App\Http\Requests\Category\CategoryStoreRequest;
use App\Http\Requests\Category\CategoryUpdateRequest;
use App\Http\Resources\Category\CategoryResource;
use App\Repositories\Categories\CategoryStoreDTO;
use App\Repositories\Categories\CategoryUpdateDTO;
use App\Services\Category\PrivateCategoryService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use OpenApi\Attributes as OA;

class CategoryController extends Controller
{
    public function __construct(
        protected PrivateCategoryService $categoryService,
    ) {
    }

    /**
     * @param CategoryIndexRequest $request
     * @return JsonResponse
     */
    #[OA\Get(
        path: '/v1/admin/categories',
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
                description: 'Show all categories',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(
                            property: 'data',
                            ref: '#/components/schemas/Category',
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
    public function index(CategoryIndexRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $collection = $this->categoryService->getAllCategories($validated['lastId']);
        $resource = CategoryResource::collection($collection);

        return $resource->response()->setStatusCode(200);
    }

    /**
     * @param CategoryStoreRequest $request
     * @return JsonResponse
     */
    #[OA\Post(
        path: '/v1/admin/categories',
        security: [['bearerAuth' => []]],
        tags: ['Admin Panel'],
        parameters: [
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
                name: 'title',
                description: 'Name of the category',
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
                description: 'Show created category',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(
                            property: 'data',
                            ref: '#/components/schemas/Category',
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
    public function store(CategoryStoreRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $DTO = new CategoryStoreDTO(...$validated);
        $service = $this->categoryService->insertAndGetId($DTO);
        $resource = new CategoryResource($service);

        return $resource->response()->setStatusCode(201);
    }

    /**
     * @param CategoryShowRequest $request
     * @return JsonResponse
     */
    #[OA\Get(
        path: '/v1/admin/categories/{id}',
        security: [['bearerAuth' => []]],
        tags: ['Admin Panel'],
        parameters: [
            new OA\Parameter(
                name: 'id',
                description: 'Category ID',
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
                description: 'Show city by id',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(
                            property: 'data',
                            ref: '#/components/schemas/Category',
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
    public function show(CategoryShowRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $service = $this->categoryService->getById($validated['id']);
        $resource = new CategoryResource($service);

        return $resource->response()->setStatusCode(200);
    }

    /**
     * @param CategoryUpdateRequest $request
     * @return JsonResponse
     */
    #[OA\Patch(
        path: '/v1/admin/categories/{id}',
        security: [['bearerAuth' => []]],
        tags: ['Admin Panel'],
        parameters: [
            new OA\Parameter(
                name: 'id',
                description: 'Category ID',
                in: 'path',
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
                name: 'title',
                description: 'Name of the category',
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
                description: 'Show all cities',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(
                            property: 'data',
                            ref: '#/components/schemas/Category',
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
    public function update(CategoryUpdateRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $DTO = new CategoryUpdateDTO(...$validated);
        $service = $this->categoryService->updateAndGetById($DTO);
        $resource = new CategoryResource($service);

        return $resource->response()->setStatusCode(200);
    }

    /**
     * @param CategoryDestroyRequest $request
     * @return Response
     */
    #[OA\Delete(
        path: '/v1/admin/categories/{id}',
        security: [['bearerAuth' => []]],
        tags: ['Admin Panel'],
        parameters: [
            new OA\Parameter(
                name: 'id',
                description: 'Category ID',
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
                description: 'The category has been deleted',
            ),
        ],
    )]
    public function destroy(CategoryDestroyRequest $request): Response
    {
        $validated = $request->validated();
        $this->categoryService->deleteById($validated['id']);

        return response()->noContent();
    }
}
