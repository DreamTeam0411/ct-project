<?php

namespace App\Http\Controllers\API\v1\Authentication;

use App\Http\Controllers\Controller;
use App\Http\Requests\Password\ChangePasswordRequest;
use App\Http\Requests\Password\ResetPasswordRequest;
use App\Http\Resources\Errors\ExceptionResource;
use App\Http\Resources\Password\ResetPasswordResource;
use App\Repositories\UserRepository\ChangePasswordDTO;
use App\Services\Password\PasswordService;
use Exception;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;

class PasswordController extends Controller
{
    public function __construct(
        protected PasswordService $passwordService,
    ) {
    }

    /**
     * @param ResetPasswordRequest $request
     * @return JsonResponse
     */
    #[OA\Post(
        path: '/v1/reset-password',
        tags: ['Password'],
        parameters: [
            new OA\Parameter(
                name: 'email',
                description: 'Only emails of existing users, max:255 symbols',
                in: 'query',
                required: true,
                schema: new OA\Schema(
                    type: 'string',
                    maxLength: 255,
                )
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Generates reset password token',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(
                            property: 'data',
                            ref: '#/components/schemas/ResetPassword',
                        )
                    ],
                    example: [
                        'data' => [
                            'email' => 'example@gmail.com',
                            'token' => '736b32a5265d825732add264f4f85d9e090e4231193a2ad916d962b5a9aca089',
                        ],
                    ]
                ),
            ),
            new OA\Response(
                response: 400,
                description: 'The user\'s email is not exist',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(
                            property: 'data',
                            ref: '#/components/schemas/Error',
                        )
                    ],
                    example: [
                        'data' => [
                            'message' => 'The user is not exist.',
                            'code' => 400,
                        ],
                    ]
                ),
            )
        ],
    )]
    public function resetPassword(ResetPasswordRequest $request): JsonResponse
    {
        $validated = $request->validated();

        try {
            $service = $this->passwordService->resetPasswordPreparation($validated['email']);
        } catch (Exception $e) {
            return (new ExceptionResource($e))->response()
                ->setStatusCode($e->getCode());
        }

        $resource = new ResetPasswordResource($service);

        return $resource->response()->setStatusCode(200);
    }

    /**
     * @param ChangePasswordRequest $request
     * @return JsonResponse
     */
    #[OA\Post(
        path: '/v1/change-password/{token}',
        tags: ['Password'],
        parameters: [
            new OA\Parameter(
                name: 'token',
                in: 'path',
                required: true,
                schema: new OA\Schema(
                    type: 'string',
                )
            ),
            new OA\Parameter(
                name: 'email',
                in: 'query',
                required: true,
                schema: new OA\Schema(
                    type: 'string',
                ),
            ),
            new OA\Parameter(
                name: 'password',
                in: 'query',
                required: true,
                schema: new OA\Schema(
                    type: 'string',
                    maxLength: 255,
                )
            ),
            new OA\Parameter(
                name: 'password_confirmation',
                in: 'query',
                schema: new OA\Schema(
                    type: 'string',
                    maxLength: 255,
                )
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'The password has been changed',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(
                            property: 'message',
                            type: 'string',
                        ),
                    ],
                    example: [
                        'message' => 'The password has been changed.'
                    ]
                )
            ),
            new OA\Response(
                response: 400,
                description: 'Invalid token or email',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(
                            property: 'data',
                            ref: '#/components/schemas/Error',
                        ),
                    ],
                    example: [
                        'data' => [
                            'message' => 'Invalid token or email.',
                            'code' => 400
                        ]
                    ],
                ),
            ),
            new OA\Response(
                response: 422,
                description: 'Validation errors',
                content: new OA\JsonContent(
                    ref: '#/components/schemas/ValidationErrors',
                ),
            )
        ],
    )]
    public function changePassword(ChangePasswordRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $DTO = new ChangePasswordDTO($validated);

        try {
            $this->passwordService->changePassword($DTO);
        } catch (Exception $e) {
            return (new ExceptionResource($e))->response()
                ->setStatusCode($e->getCode());
        }

        return response()->json(['message' => 'The password has been changed.'])
            ->setStatusCode(200);
    }
}
