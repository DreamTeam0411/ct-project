<?php

namespace App\Http\Controllers\API\v1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminUser\AdminUserUpdateRequest;
use App\Http\Resources\User\UserResource;
use App\Repositories\UserRepository\UserUpdateDTO;
use App\Services\Users\UserService;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;

class AdminUserController extends Controller
{
    /**
     * @param UserService $userService
     */
    public function __construct(
        protected UserService $userService,
    ) {
    }

    /**
     * @param AdminUserUpdateRequest $request
     * @return JsonResponse
     */
    #[OA\Patch(
        path: '/v1/admin/users/{id}',
        security: [['bearerAuth' => []]],
        tags: ['Admin Panel'],
        parameters: [
            new OA\Parameter(
                name: 'id',
                description: 'Min: 1',
                in: 'path',
                required: true,
                schema: new OA\Schema(
                    type: 'integer',
                    minimum: 1,
                )
            ),
            new OA\Parameter(
                name: 'firstName',
                description: 'Max: 255 symbols',
                in: 'query',
                required: true,
                schema: new OA\Schema(
                    type: 'string',
                    maxLength: 255,
                )
            ),
            new OA\Parameter(
                name: 'lastName',
                description: 'Max: 255 symbols',
                in: 'query',
                required: true,
                schema: new OA\Schema(
                    type: 'string',
                    maxLength: 255,
                )
            ),
            new OA\Parameter(
                name: 'phoneNumber',
                description: 'Min: 4 symbols, max: 30, only numbers allow',
                in: 'query',
                required: true,
                schema: new OA\Schema(
                    type: 'string',
                    maxLength: 30,
                    minLength: 4
                )
            ),
            new OA\Parameter(
                name: 'address',
                description: 'Max: 255 symbols',
                in: 'query',
                required: true,
                schema: new OA\Schema(
                    type: 'string',
                    maxLength: 255,
                )
            ),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Successful update',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(
                            property: 'data',
                            ref: '#/components/schemas/User',
                        ),
                    ]
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
    public function update(AdminUserUpdateRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $DTO = new UserUpdateDTO(...$validated);

        $service = $this->userService->update($DTO);
        $resource = new UserResource($service);

        return $resource->response()->setStatusCode(200);
    }
}
