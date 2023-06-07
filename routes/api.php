<?php
declare(strict_types=1);

use Slim\App;
use App\Controllers\Api\CarroController;
use App\Controllers\Api\MedicamentoController;
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
        $api->get("/carros/{carroId:[0-9]+}/get-medicamentos", [
            MedicamentoController::class,
            "getFromCarro"
        ]);

        /* ---------------------------------------------------------------------
        *  Medicamentos
        */
        $api->post("/medicamentos/create", [
            MedicamentoController::class,
            "create"
        ]);
        $api->delete("/medicamentos/{medicamentoId:[0-9]+}/delete", [
            MedicamentoController::class,
            "delete"
        ]);
    })->add(JsonBodyParserMiddleware::class);
}
