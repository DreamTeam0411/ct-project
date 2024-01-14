<?php

namespace App\Http\Middleware\API;

use App\Enums\Role;
use App\Repositories\UserRepository\UserRepository;
use App\Services\Users\AuthUserService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class IsAuthUserAdminMiddleware
{
    public function __construct(
        protected UserRepository $userRepository,
        protected AuthUserService $authUserService,
    ) {
    }

    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (
            $this->userRepository
            ->isUserHasRole($this->authUserService->getUserIdByApi(), Role::IS_ADMIN) === false
        ) {
            throw new NotFoundHttpException('The route ' . $request->path() . ' could not be found.');
        }

        return $next($request);
    }
}
