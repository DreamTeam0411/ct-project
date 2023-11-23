<?php

namespace App\Http\Middleware\API;

use App\Services\UserService\AuthUserService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsEmailVerifiedMiddleware
{
    public function __construct(
        protected AuthUserService $authUserService
    ) {
    }

    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($this->authUserService->isEmailVerified() === false) {
            return response()->json(['message' => 'Your email is not verified.'])
                ->setStatusCode(200);
        }

        return $next($request);
    }
}
