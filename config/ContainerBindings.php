<?php
declare(strict_types=1);

use App\Config;
use DI\ContainerBuilder;

$container = new ContainerBuilder();

$container->addDefinitions([
    Config::class => function () {
        return new Config(require __DIR__ . "/configs.php");
    },
]);

return $container->build();
