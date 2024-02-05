<?php

namespace App\Services\Service\Update;

use App\Repositories\Services\ServiceUpdateDTO;
use App\Services\Service\Update\Handlers\PhotoUpdateHandler;
use App\Services\Service\Update\Handlers\ServiceUpdateHandler;
use Illuminate\Pipeline\Pipeline;

class ServiceUpdateService
{
    protected const HANDLERS = [
        ServiceUpdateHandler::class,
        PhotoUpdateHandler::class,
    ];

    public function __construct(
        protected Pipeline $pipeline,
    ) {
    }

    public function handle(ServiceUpdateDTO $DTO): ServiceUpdateDTO
    {
        return $this->pipeline
            ->send($DTO)
            ->through(self::HANDLERS)
            ->then(function (ServiceUpdateDTO $DTO) {
                return $DTO;
            });
    }
}
