<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Authentication\LoginUserRequest;
use App\Http\Requests\Authentication\RegisteredUserRequest;
use App\Http\Resources\User\UserResource;
use App\Repositories\UserRepository\RegisterUserDTO;
use App\Services\UserService\AuthUserService;
use App\Services\UserService\Login\LoginDTO;
use App\Services\UserService\Login\LoginService;
use App\Services\UserService\UserService;
use Illuminate\Http\JsonResponse;

class AuthenticationController extends Controller
{
    /**
     * @param UserService $userService
     * @param AuthUserService $authUserService
     */
    public function __construct(
        protected UserService $userService,
        protected AuthUserService $authUserService,
    ) {
    }

    public function register(RegisteredUserRequest $request): JsonResponse
    {
        $DTO = new RegisterUserDTO(...$request->validated());
        $service = $this->userService->register($DTO);
        $resource = new UserResource($service);

        return $resource->response()->setStatusCode(201);
    }

    public function login(LoginUserRequest $request, LoginService $service): JsonResponse
    {
        $DTO = new LoginDTO(...$request->validated());
        $user = $service->handle($DTO);

        $resource = new UserResource($user->getUserIterator());
        $bearerToken = $user->getBearerToken();

        return $resource->additional([
            'Bearer' => $bearerToken,
        ])->response()->setStatusCode(200);
    }

    public function profile(): JsonResponse
    {
        $userId = $this->authUserService->getUserIdByApi();
        $user = $this->userService->getUserById($userId);

        $resource = new UserResource($user);

        return $resource->response()->setStatusCode(200);
    }

    public function logout(): JsonResponse
    {
        $userToken = $this->authUserService->getUserToken();
        $userToken->revoke();

        return response()->json(['message' => 'User was logged out.'])->setStatusCode(200);
    }
}
