<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\UserService\AuthUserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

class EmailVerificationController extends Controller
{
    /**
     * @param AuthUserService $authUserService
     */
    public function __construct(
        protected AuthUserService $authUserService
    ) {
    }

    /**
     * @return JsonResponse
     */
    #[OA\Post(
        path: '/v1/resend-verification-email',
        security: [['bearerAuth' => []]],
        tags: ['Authentication'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Send verification email',
                content: new OA\JsonContent(
                    example: ['message' => 'Verification mail sent on your email.']
                )
            ),
            new OA\Response(
                response: 400,
                description: 'If email is verified already',
                content: new OA\JsonContent(
                    example: ['message' => 'Your email is already verified.']
                )
            )
        ],
    )]
    public function resend(): JsonResponse
    {
        if ($this->authUserService->isEmailVerified() === true) {
            return response()->json(['message' => 'Your email is already verified.'])
                ->setStatusCode(400);
        }

        $this->authUserService->sendEmailVerificationNotification();

        return response()->json(['message' => 'Verification mail sent on your email.'])
            ->setStatusCode(200);
    }

    /**
     * @param Request $request
     * @param int $userId
     * @return JsonResponse
     */
    #[OA\Get(
        path: '/v1/email-verify/{id}',
        tags: ['Authentication'],
        parameters: [
            new OA\Parameter(
                name: 'id',
                description: 'User ID',
                in: 'path',
                schema: new OA\Schema(
                    type: 'integer',
                    minimum: 1,
                ),
            ),
            new OA\Parameter(
                name: 'expires',
                description: 'timestamp',
                in: 'query',
                schema: new OA\Schema(
                    type: 'integer',
                ),
            ),
            new OA\Parameter(
                name: 'hash',
                description: 'Hashed email',
                in: 'query',
                schema: new OA\Schema(
                    type: 'string',
                ),
            ),
            new OA\Parameter(
                name: 'signature',
                description: 'electronic signature',
                in: 'query',
                schema: new OA\Schema(
                    type: 'string',
                )
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Verify your email',
                content: new OA\JsonContent(
                    example: ['message' => 'Your email has been verified.']
                )
            ),
            new OA\Response(
                response: 400,
                description: 'If url expired or invalid',
                content: new OA\JsonContent(
                    example: ['message' => 'Invalid/Expired url provided.']
                )
            )
        ],
    )]
    public function verify(Request $request, int $userId): JsonResponse
    {
        if ($request->hasValidSignature() === false) {
            return response()->json(['message' => 'Invalid/Expired url provided.'])
                ->setStatusCode(400);
        }

        $user = User::findOrfail($userId);

        if ($user->hasVerifiedEmail() === false) {
            $user->markEmailasVerified();
        }

        return response()->json(['message' => 'Your email has been verified.'])
            ->setStatusCode(200);
    }
}
