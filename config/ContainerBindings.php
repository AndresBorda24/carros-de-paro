<?php
declare(strict_types=1);

use App\Config;
use Medoo\Medoo;
use DI\ContainerBuilder;

$container = new ContainerBuilder();

$container->addDefinitions([
    Config::class => function () {
        return new Config(require __DIR__ . "/configs.php");
    },
    Medoo::class => function (Config $c) {
        return new Medoo([
            'type' => 'mysql',
            'host' => $c->get('db.host'),
            'database' => $c->get('db.name'),
            'username' => $c->get('db.user'),
            'password' => $c->get('db.pass'),
            'port' => $c->get('db.port', 3306),
        ]);
    }
]);

return $container->build();
