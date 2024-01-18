<?php

namespace App\Http\Controllers;

use App\Http\Resources\City\CityIdNameAndSlugResource;
use App\Services\City\CityService;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;

class CityController extends Controller
{
    public function __construct(
        protected CityService $cityService,
    ) {
    }

    /**
     * @return JsonResponse
     */
    #[OA\Get(
        path: '/v1/cities',
        tags: ['Cities'],
        parameters: [],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Show all cities',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(
                            property: 'data',
                            ref: '#/components/schemas/CityIdNameAndSlug',
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
        $service = $this->cityService->getAllPublicCities();
        $resource = CityIdNameAndSlugResource::collection($service);

        return $resource->response()->setStatusCode(200);
    }
}
