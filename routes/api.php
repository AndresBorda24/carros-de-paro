<?php
declare(strict_types=1);

use Slim\App;
use App\Controllers\Api\CarroController;
use App\Middleware\JsonBodyParserMiddleware;
use Slim\Routing\RouteCollectorProxy as Group;

function loadApiRoutes(App $app) {
    $app->group("/api", function(Group $api) {
        $api->post("/carros/create", [
            CarroController::class,
            "create"
        ]);
        $api->get("/carros/get-all", [
            CarroController::class,
            "getAll"
        ]);
    })->add(JsonBodyParserMiddleware::class);
}
