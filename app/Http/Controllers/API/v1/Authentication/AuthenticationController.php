<?php

namespace App\Http\Controllers\API\v1\Authentication;

use App\Http\Controllers\Controller;
use App\Http\Requests\Authentication\LoginUserRequest;
use App\Http\Requests\Authentication\RegisteredUserRequest;
use App\Http\Resources\Errors\ExceptionResource;
use App\Http\Resources\User\UserResource;
use App\Repositories\UserRepository\RegisterUserDTO;
use App\Services\EmailVerification\EmailVerificationService;
use App\Services\Users\AuthUserService;
use App\Services\Users\Login\LoginDTO;
use App\Services\Users\Login\LoginService;
use App\Services\Users\UserService;
use Exception;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;

class AuthenticationController extends Controller
{
    /**
     * @param UserService $userService
     * @param AuthUserService $authUserService
     * @param EmailVerificationService $emailVerificationService
     */
    public function __construct(
        protected UserService $userService,
        protected AuthUserService $authUserService,
        protected EmailVerificationService $emailVerificationService,
    ) {
    }

    /**
     * @param RegisteredUserRequest $request
     * @return JsonResponse
     */
    #[OA\Post(
        path: '/v1/register',
        security: [['bearerAuth' => []]],
        tags: ['Authentication'],
        parameters: [
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
                name: 'email',
                description: 'Max: 255 symbols',
                in: 'query',
                required: true,
                schema: new OA\Schema(
                    type: 'string',
                    maxLength: 255,
                )
            ),
            new OA\Parameter(
                name: 'password',
                description: 'Min: 6 symbols, max: 255, at least one number and one capital letter',
                in: 'query',
                required: true,
                schema: new OA\Schema(
                    type: 'string',
                    maxLength: 255,
                    minLength: 6,
                )
            ),
            new OA\Parameter(
                name: 'password_confirmation',
                description: 'Should repeat password field',
                in: 'query',
                required: true,
                schema: new OA\Schema(
                    type: 'string',
                    maxLength: 255,
                    minLength: 6,
                )
            ),
        ],
        responses: [
            new OA\Response(
                response: 201,
                description: 'Successful registration',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(
                            property: 'data',
                            ref: '#/components/schemas/User',
                        ),
                        new OA\Property(
                            property: 'emailVerify',
                            ref: '#/components/schemas/EmailVerification',
                        ),
                    ]
                )
            ),
            new OA\Response(
                response: 400,
                description: 'Response for logged user',
                content: new OA\JsonContent(
                    example: ['message' => 'You are logged in already.']
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
    public function register(RegisteredUserRequest $request): JsonResponse
    {
        $DTO = new RegisterUserDTO(...$request->validated());
        $userIterator = $this->userService->register($DTO);
        $resource = new UserResource($userIterator);
        $emailVerifyDTO = $this->emailVerificationService
            ->generateEmailVerifyData(
                $userIterator->getId()
            );

        return $resource->additional([
            'emailVerify' => [
                'id'        => $emailVerifyDTO->getId(),
                'expires'   => $emailVerifyDTO->getExpires(),
                'hash'      => $emailVerifyDTO->getHash(),
                'signature' => $emailVerifyDTO->getSignature(),
            ]
        ])->response()->setStatusCode(201);
    }

    /**
     * @param LoginUserRequest $request
     * @param LoginService $service
     * @return JsonResponse
     */
    #[OA\Post(
        path: '/v1/login',
        security: [['bearerAuth' => []]],
        tags: ['Authentication'],
        parameters: [
            new OA\Parameter(
                name: 'email',
                description: 'Only email from DB, max: 255 symbols',
                in: 'query',
                required: true,
                schema: new OA\Schema(
                    type: 'string',
                    maxLength: 255,
                )
            ),
            new OA\Parameter(
                name: 'password',
                description: 'Min: 6 symbols, max: 255, at least one number and one capital letter',
                in: 'query',
                required: true,
                schema: new OA\Schema(
                    type: 'string',
                    maxLength: 255,
                    minLength: 6,
                )
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Successful login',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(
                            property: 'data',
                            ref: '#/components/schemas/User',
                        ),
                        new OA\Property(
                            property: 'Bearer',
                            ref: '#/components/schemas/Bearer'
                        ),
                    ]
                ),
            ),
            new OA\Response(
                response: 400,
                description: 'Response for logged user',
                content: new OA\JsonContent(
                    example: ['message' => 'You are logged in already.']
                )
            ),
            new OA\Response(
                response: 422,
                description: 'Validation errors',
                content: new OA\JsonContent(
                    ref: '#/components/schemas/ValidationErrors'
                )
            ),
            new OA\Response(
                response: 500,
                description: 'Wrong email or password',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(
                            property: 'data',
                            ref: '#/components/schemas/Error'
                        )
                    ]
                )
            ),
        ],
    )]
    public function login(LoginUserRequest $request, LoginService $service): JsonResponse
    {
        $DTO = new LoginDTO(...$request->validated());

        try {
            $user = $service->handle($DTO);
        } catch (Exception $e) {
            return (new ExceptionResource($e))->response()
                ->setStatusCode($e->getCode());
        }

        $resource = new UserResource($user->getUserIterator());
        $bearerToken = $user->getBearerToken();

        return $resource->additional([
            'Bearer' => $bearerToken,
        ])->response()->setStatusCode(200);
    }

    /**
     * @return JsonResponse
     */
    #[OA\Get(
        path: '/v1/profile',
        security: [['bearerAuth' => []]],
        tags: ['Authentication'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Shows user profile',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(
                            property: 'data',
                            ref: '#/components/schemas/User',
                        )
                    ]

                )
            ),
            new OA\Response(
                response: 401,
                description: 'Error: Unauthorized',
                content: new OA\JsonContent(
                    example: ['message' => 'Unauthenticated.']
                )
            ),
        ],
    )]
    public function profile(): JsonResponse
    {
        $userId = $this->authUserService->getUserIdByApi();
        $user = $this->userService->getUserById($userId);

        $resource = new UserResource($user);

        return $resource->response()->setStatusCode(200);
    }

    /**
     * @return JsonResponse
     */
    #[OA\Post(
        path: '/v1/logout',
        security: [['bearerAuth' => []]],
        tags: ['Authentication'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Logout user',
                content: new OA\JsonContent(
                    example: ['message' => 'User was logged out.'],
                )
            ),
            new OA\Response(
                response: 401,
                description: 'Error: Unauthorized',
                content: new OA\JsonContent(
                    example: ['message' => 'Unauthenticated.']
                )
            ),
        ],
    )]
    public function logout(): JsonResponse
    {
        $userToken = $this->authUserService->getUserToken();
        $userToken->revoke();

        return response()->json(['message' => 'User was logged out.'])->setStatusCode(200);
    }
}