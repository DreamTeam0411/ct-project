<?php

namespace App\Services\EmailVerificationService;

use App\Notifications\EmailVerification\EmailVerificationDTO;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Support\Facades\Notification;

class EmailVerificationService
{
    public function sendNotification(EmailVerificationDTO $DTO): void
    {
        Notification::send($DTO, new VerifyEmail);
    }
}
