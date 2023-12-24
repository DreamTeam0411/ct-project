<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use OpenApi\Attributes as OA;

#[OA\Info(version: "0.1", title: "ct-project-api")]
#[OA\Server(url: 'https://ct-project.pp.ua/api/')]
#[OA\Server(url: 'http://172.19.0.1/api/')]
#[OA\Components(
    securitySchemes: [
        new OA\SecurityScheme(
            securityScheme: 'bearerAuth',
            type: 'http',
            name: 'bearerAuth',
            in: 'header',
            bearerFormat: 'JWT',
            scheme: 'bearer',
        )
    ]
)]
class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}
