<?php

namespace App\Services\EmailVerificationService;

use App\Services\UserService\UserService;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\URL;

class EmailVerificationService
{
    public function __construct(
        protected UserService $userService,
    ) {
    }

    public function generateEmailVerifyData(int $userId): EmailVerifyDTO
    {
        $user = $this->userService->getUserById($userId);

        $url = URL::temporarySignedRoute(
            'verification.verify',
            Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60)),
            [
                'id' => $user->getId(),
                'hash' => sha1($user->getEmail()),
            ]
        );

        $parseUrlQuery = parse_url($url, PHP_URL_QUERY);
        parse_str($parseUrlQuery, $query);

        return new EmailVerifyDTO(
            $user->getId(),
            $query['expires'],
            $query['hash'],
            $query['signature'],
        );
    }
}
