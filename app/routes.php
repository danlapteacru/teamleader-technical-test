<?php

declare(strict_types=1);

use App\Application\Actions\Discount\ApplyDiscountAction;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;

return function (App $app) {
    $app->options('/{routes:.*}', function (Request $request, Response $response) {
        // CORS Pre-Flight OPTIONS Request Handler
        return $response;
    });

    $app->post('/order/discounts', ApplyDiscountAction::class);
};
