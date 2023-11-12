<?php

namespace App\Services\UserService\Login;

use App\Services\UserService\Login\Handlers\CheckValidDataHandler;
use App\Services\UserService\Login\Handlers\SetAuthorizedUserHandler;
use App\Services\UserService\Login\Handlers\SetPersonalTokenHandler;
use Illuminate\Pipeline\Pipeline;

class LoginService
{
    protected const HANDLERS = [
        CheckValidDataHandler::class,
        SetAuthorizedUserHandler::class,
        SetPersonalTokenHandler::class,
    ];

    public function __construct(
        protected Pipeline $pipeline,
    ) {
    }

    public function handle(LoginDTO $loginDTO): LoginDTO
    {
        return $this->pipeline
            ->send($loginDTO)
            ->through(self::HANDLERS)
            ->then(function (LoginDTO $loginDTO) {
                return $loginDTO;
            });
    }
}
