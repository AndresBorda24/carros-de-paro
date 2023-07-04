<?php
declare(strict_types=1);

use Slim\App;
use App\Controllers\HomeController;
use App\Controllers\PrintController;

function loadWebRoutes(App $app) {
    /**
     * Esto esta para evitar e error 404 por culpa del /
    */
    $app->get("", [HomeController::class, "index"]);

    $app->get("/", [HomeController::class, "index"])->setName("carros.index");
    $app->get("/buscar-historico", [
        HomeController::class,
        "buscarHistorico"
    ])->setName("carros.buscar-historico");

    $app->get("/print/{aperturaId:[0-9]+}/apertura", [
        PrintController::class,
        "printApertura"
    ])->setName("print.apertura");
}

