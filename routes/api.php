<?php
declare(strict_types=1);

use Slim\App;
use App\Controllers\Api\CarroController;
use App\Controllers\Api\DispositivoController;
use App\Controllers\Api\MedicamentoController;
use App\Middleware\JsonBodyParserMiddleware;
use Slim\Routing\RouteCollectorProxy as Group;

function loadApiRoutes(App $app) {
    $app->group("/api", function(Group $api) {
        $api->post("/carros/create", [
            CarroController::class,
            "create"
        ]);
        $api->put("/carros/{id:[0-9]+}/update", [
            CarroController::class,
            "update"
        ]);
        $api->get("/carros/get-all", [
            CarroController::class,
            "getAll"
        ]);
        $api->get("/carros/{carroId:[0-9]+}/get-medicamentos", [
            MedicamentoController::class,
            "getFromCarro"
        ]);
        $api->get("/carros/{carroId:[0-9]+}/get-dispositivos", [
            DispositivoController::class,
            "getFromCarro"
        ]);

        /* ---------------------------------------------------------------------
        *  Medicamentos
        */
        $api->post("/medicamentos/create", [
            MedicamentoController::class,
            "create"
        ]);
        $api->put("/medicamentos/{id:[0-9]+}/update", [
            MedicamentoController::class,
            "update"
        ]);
        $api->delete("/medicamentos/{id:[0-9]+}/delete", [
            MedicamentoController::class,
            "delete"
        ]);

        /* ---------------------------------------------------------------------
        *  Dispositivos
        */
        $api->post("/dispositivos/create", [
            DispositivoController::class,
            "create"
        ]);
        $api->put("/dispositivos/{id:[0-9]+}/update", [
            DispositivoController::class,
            "update"
        ]);
        $api->delete("/dispositivos/{id:[0-9]+}/delete", [
            DispositivoController::class,
            "delete"
        ]);
    })->add(JsonBodyParserMiddleware::class);
}
