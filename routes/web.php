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

    $app->get("/", [HomeController::class, "index"])
        ->setName("carros.index");
    $app->get("/estantes", [HomeController::class, "estantes"])
        ->setName("carros.estantes");
    $app->get("/kits", [HomeController::class, "kits"])
        ->setName("carros.kits");
    $app->get("/buscar-historico", [HomeController::class, "buscarHistorico" ])
        ->setName("carros.buscar-historico");

    $app->get("/print/{aperturaId:[0-9]+}/apertura[/{current:[1]}]", [
        PrintController::class,
        "printApertura"
    ])->setName("print.apertura");

    $app->get("/print/all/{tipo}", [
        PrintController::class,
        "printAll"
    ])->setName("print.all");


    $app->get("/to-excel/all/{tipo}", [
        PrintController::class,
        "toExcel"
    ])->setName("excel.all");

    $app->get("/to-excel/{carroId:[0-9]+}", [
        PrintController::class,
        "toExcelIndividual"
    ])->setName("excel.individual");
}
