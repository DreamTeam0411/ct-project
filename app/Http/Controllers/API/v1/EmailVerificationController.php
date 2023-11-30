<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Authentication\EmailVerificationRequest;
use App\Http\Resources\User\EmailVerificationResource;
use App\Models\User;
use App\Services\EmailVerificationService\EmailVerificationService;
use App\Services\UserService\AuthUserService;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;

class EmailVerificationController extends Controller
{
    /**
     * @param AuthUserService $authUserService
     * @param EmailVerificationService $emailVerificationService
     */
    public function __construct(
        protected AuthUserService $authUserService,
        protected EmailVerificationService $emailVerificationService,
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
                description: 'Send verification email data',
                content: new OA\JsonContent(
                    ref: '#/components/schemas/EmailVerification'
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

        $resource = new EmailVerificationResource(
            $this->emailVerificationService->generateEmailVerifyData(
                $this->authUserService->getUserId()
            )
        );

        return $resource->response()->setStatusCode(200);
    }

    /**
     * @param EmailVerificationRequest $request
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
                description: 'Verify your email or email is already verified',
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
            ),
            new OA\Response(
                response: 422,
                description: 'Validation errors',
                content: new OA\JsonContent(
                    ref: '#/components/schemas/ValidationErrors'
                )
            )
        ],
    )]
    public function verify(EmailVerificationRequest $request): JsonResponse
    {
        $validated = $request->validated();

        if ($request->hasValidSignature() === false) {
            return response()->json(['message' => 'Invalid/Expired url provided.'])
                ->setStatusCode(400);
        }

        $user = User::findOrfail($validated['id']);

        if ($user->hasVerifiedEmail() === false) {
            $user->markEmailasVerified();
        }

        return response()->json(['message' => 'Your email has been verified.'])
            ->setStatusCode(200);
    }
}
