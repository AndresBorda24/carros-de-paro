<?php
declare(strict_types=1);

use Slim\App;
use App\Controllers\Api\AperturasController;
use App\Controllers\Api\CarroController;
use App\Controllers\Api\DispositivoController;
use App\Controllers\Api\HistoricoController;
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
        $api->delete("/carros/{id:[0-9]+}/delete", [
            CarroController::class,
            "delete"
        ]);
        $api->get("/carros/get-all", [
            CarroController::class,
            "getAll"
        ]);
        $api->get("/carros/{id:[0-9]+}/get-aperturas", [
            CarroController::class,
            "getAperturas"
        ]);
        $api->get("/carros/aperturas/{aperturaId:[0-9]+}/get", [
            CarroController::class,
            "findApertura"
        ]);
        $api->post("/carros/{id:[0-9]+}/save-apertura", [
            CarroController::class,
            "saveApertura"
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
        $api->post("/medicamentos/create/{apId:[0-9]+}", [
            MedicamentoController::class,
            "create"
        ]);
        $api->put("/medicamentos/{id:[0-9]+}/update/{apId:[0-9]+}", [
            MedicamentoController::class,
            "update"
        ]);
        $api->put("/medicamentos/{carroId:[0-9]+}/update-carro", [
            MedicamentoController::class,
            "updateCarro"
        ]);
        $api->delete("/medicamentos/{id:[0-9]+}/delete/{apId:[0-9]+}", [
            MedicamentoController::class,
            "delete"
        ]);

        /* ---------------------------------------------------------------------
        *  Dispositivos
        */
        $api->post("/dispositivos/create/{apId:[0-9]+}", [
            DispositivoController::class,
            "create"
        ]);
        $api->put("/dispositivos/{id:[0-9]+}/update/{apId:[0-9]+}", [
            DispositivoController::class,
            "update"
        ]);
        $api->put("/dispositivos/{carroId:[0-9]+}/update-carro", [
            DispositivoController::class,
            "updateCarro"
        ]);
        $api->delete("/dispositivos/{id:[0-9]+}/delete/{apId:[0-9]+}", [
            DispositivoController::class,
            "delete"
        ]);

        /* ---------------------------------------------------------------------
        *  Historico
        */
        $api->get("/historico/{carroId:[0-9]+}/list", [
            HistoricoController::class,
            "getList"
        ]);
        $api->get("/historico/{id:[0-9]+}/get", [
            HistoricoController::class,
            "getHistorico"
        ]);
        $api->get("/historico/search", [
            HistoricoController::class,
            "searchHistorico"
        ]);

        $api->group("/aperturas", function(Group $apertura) {
            $apertura->post("/create", [AperturasController::class, "store"]);
        });

        /* ---------------------------------------------------------------------
        *  Tratando de evitar el error de las sesiones
        */
        $api->get(
            "/session-pulse",
            \App\Controllers\Api\SessionPulseController::class
        );
    })->add(JsonBodyParserMiddleware::class);
}
