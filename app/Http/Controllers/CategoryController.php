<?php

namespace App\Http\Controllers;

use App\Http\Resources\Category\CategoryIdNameSlugResource;
use App\Services\Category\CategoryService;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;

class CategoryController extends Controller
{
    public function __construct(
        protected CategoryService $categoryService,
    ) {
    }

    /**
     * @return JsonResponse
     */
    #[OA\Get(
        path: '/v1/categories',
        tags: ['Categories'],
        parameters: [],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Show all categories',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(
                            property: 'data',
                            ref: '#/components/schemas/CategoryIdNameSlug',
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
    public function index(): JsonResponse
    {
        $collection = $this->categoryService->getAllPublicCategories();
        $resource = CategoryIdNameSlugResource::collection($collection);

        return $resource->response()->setStatusCode(200);
    }
}
