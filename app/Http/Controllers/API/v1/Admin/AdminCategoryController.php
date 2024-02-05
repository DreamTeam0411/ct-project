<?php

namespace App\Http\Controllers\API\v1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminCategory\CategoryDestroyRequest;
use App\Http\Requests\Admin\AdminCategory\CategoryIndexRequest;
use App\Http\Requests\Admin\AdminCategory\CategoryShowRequest;
use App\Http\Requests\Admin\AdminCategory\AdminCategoryStoreRequest;
use App\Http\Requests\Admin\AdminCategory\AdminCategoryUpdateRequest;
use App\Http\Resources\Category\CategoryResource;
use App\Http\Resources\Errors\ExceptionResource;
use App\Repositories\Categories\CategoryStoreDTO;
use App\Repositories\Categories\CategoryUpdateDTO;
use App\Repositories\Categories\Iterators\PrivateCategoryIterator;
use App\Services\Category\CategoryImageStorage;
use App\Services\Category\CategoryService;
use App\Services\Category\Update\CategoryUpdateService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use OpenApi\Attributes as OA;

class AdminCategoryController extends Controller
{
    public function __construct(
        protected CategoryService $categoryService,
        protected CategoryUpdateService $categoryUpdateService,
    ) {
    }

    /**
     * @param CategoryIndexRequest $request
     * @return JsonResponse
     */
    #[OA\Get(
        path: '/v1/admin/categories',
        summary: 'Get 100 categories via lazy loading',
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
                        new OA\Property(
                            property: 'meta',
                            properties: [
                                new OA\Property(
                                    property: 'lastId',
                                    type: 'integer',
                                ),
                            ]
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
        $collection = $this->categoryService->getAllPrivateCategories($validated['lastId']);
        /** @var PrivateCategoryIterator $last */
        $last = $collection->last();
        $resource = CategoryResource::collection($collection)
            ->additional(['meta' => [
                'lastId' => $last->getId(),
            ]]);

        return $resource->response()->setStatusCode(200);
    }

    /**
     * @param AdminCategoryStoreRequest $request
     * @return JsonResponse
     * @throws Exception
     */
    #[OA\Post(
        path: '/v1/admin/categories',
        summary: 'Insert a new category',
        security: [['bearerAuth' => []]],
        requestBody: new OA\RequestBody(
            content: new OA\MediaType(
                mediaType: 'multipart/form-data',
                schema: new OA\Schema(
                    properties: [
                        new OA\Property(
                            property: 'icon',
                            description: 'Binary content of file',
                            type: 'string',
                            format: 'binary',
                        ),
                    ],
                ),
            ),
        ),
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
                response: 400,
                description: 'Exception error',
                content: new OA\JsonContent(
                    ref: '#/components/schemas/Error',
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
    public function store(AdminCategoryStoreRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $DTO = new CategoryStoreDTO(...$validated);

        try {
            $service = $this->categoryService->insertAndGetId($DTO);
        } catch (Exception $e) {
            return (new ExceptionResource($e))
                ->response()
                ->setStatusCode($e->getCode());
        }

        $resource = new CategoryResource($service);

        return $resource->response()->setStatusCode(201);
    }

    /**
     * @param CategoryShowRequest $request
     * @return JsonResponse
     */
    #[OA\Get(
        path: '/v1/admin/categories/{id}',
        summary: 'Get info about specified category',
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
     * @param AdminCategoryUpdateRequest $request
     * @return JsonResponse
     * @throws Exception
     */
    #[OA\Patch(
        path: '/v1/admin/categories/{id}',
        summary: 'Update the specific category',
        security: [['bearerAuth' => []]],
        requestBody: new OA\RequestBody(
            content: new OA\MediaType(
                mediaType: 'multipart/form-data',
                schema: new OA\Schema(
                    properties: [
                        new OA\Property(
                            property: 'icon',
                            description: 'NOT IMPLEMENT YET',
                            type: 'string',
                            format: 'binary',
                        ),
                    ],
                ),
            ),
        ),
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
                description: 'Show category',
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
                response: 400,
                description: 'Exception error',
                content: new OA\JsonContent(
                    ref: '#/components/schemas/Error',
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
    public function update(AdminCategoryUpdateRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $DTO = new CategoryUpdateDTO(...$validated);

        try {
            $afterResultDTO = $this->categoryUpdateService->handle($DTO);
        } catch (Exception $e) {
            return (new ExceptionResource($e))
                ->response()
                ->setStatusCode($e->getCode());
        }

        $service = $this->categoryService->getById(
            $afterResultDTO->getId()
        );

        $resource = new CategoryResource($service);
        return $resource->response()->setStatusCode(200);
    }

    /**
     * @param CategoryDestroyRequest $request
     * @return JsonResponse|Response
     */
    #[OA\Delete(
        path: '/v1/admin/categories/{id}',
        summary: 'Delete the specific category',
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
            new OA\Response(
                response: 400,
                description: 'The category used by other services.',
                content: new OA\JsonContent(
                    example: [
                        'data' => [
                            'message' => 'This category is using by other services.',
                            'code'    => 400,
                        ]
                    ],
                )
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
    public function destroy(CategoryDestroyRequest $request): JsonResponse|Response
    {
        $validated = $request->validated();

        try {
            $this->categoryService->deleteById($validated['id']);
        } catch (Exception $e) {
            return (new ExceptionResource($e))
                ->response()
                ->setStatusCode($e->getCode());
        }

        return response()->noContent();
    }
}
