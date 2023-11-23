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

        $api->get("/estantes/get-all", [CarroController::class, "getAllEstantes"]);


        /* ---------------------------------------------------------------------
        *  Medicamentos
        */
        $api->group("/medicamentos", function(Group $med) {
            $med->post("/create", [MedicamentoController::class, "create"]);
            $med->put("/{id:[0-9]+}/update", [
                MedicamentoController::class, "update"
            ]);
            $med->delete("/{id:[0-9]+}/delete", [
                MedicamentoController::class, "delete"
            ]);
        });

        /* ---------------------------------------------------------------------
        *  Dispositivos
        */
        $api->group("/dispositivos", function(Group $dis) {
            $dis->post("/create", [DispositivoController::class, "create"]);
            $dis->put("/{id:[0-9]+}/update", [
                DispositivoController::class,
                "update"
            ]);
            $dis->delete("/{id:[0-9]+}/delete", [
                DispositivoController::class,
                "delete"
            ]);
        });

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

        /* ---------------------------------------------------------------------
        + Aperturas
        */
        $api->group("/aperturas", function(Group $apertura) {
            $apertura->post("/create", [AperturasController::class, "store"]);
            $apertura->put("/{id:[0-9]+}/update", [AperturasController::class, "update"]);
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
