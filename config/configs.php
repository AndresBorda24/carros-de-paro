<?php
return [
    "app" => [
        "name" => $_ENV["APP_NAME"],
        "ver"  => $_ENV["APP_VER"],
        "base" => $_ENV["APP_PATH"],
        "url"  => $_ENV["APP_URL"]
    ],
    "db" => [
        "host" => $_ENV["DB_HOST"],
        "name" => $_ENV["DB_NAME"],
        "user" => $_ENV["DB_USER"],
        "pass" => $_ENV["DB_PASS"],
        "port" => (int) $_ENV["DB_PORT"]
    ],
    "assets" => [
        "templates"   => __DIR__ . "/.." . $_ENV["TEMPLATES"],
        "entrypoints" => __DIR__ . "/.." . $_ENV["ENTRYPOINTS_PATH"]
    ],
    /**
     * Aquí se guardan los errores que ocurran cuando se intenta guardar el
     * registro de alguna accion en cualquier "modelo" (Medicamento,
     * Dispositivo, Carro...)
     *
     * Se guardan en un txt para que no detenga o afecte el flujo del
     * programa si falla
    */
    "errores_reg" => __DIR__ . "/.." . $_ENV["ERROR_LOG"],
    "temp" => __DIR__ . "/../temp"
];
