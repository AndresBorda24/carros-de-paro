<?php
return [
    "app" => [
        "name" => $_ENV["APP_NAME"],
        "ver"  => $_ENV["APP_VER"],
        "base" => $_ENV["APP_PATH"],
        "url"  => $_ENV["APP_URL"],
        "env"  => $_ENV["APP_ENV"]
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
    "temp" => __DIR__ . "/../temp",
    "permisos" => require __DIR__ . "/permisos.php"
];
