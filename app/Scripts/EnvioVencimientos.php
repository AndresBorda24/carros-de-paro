<?php
declare(strict_types=1);

use App\Models\Carro;
use App\Services\EnvioVencimientoService;

require __DIR__ . "/../../vendor/autoload.php";

/** @var \DI\Container */
$container  = require __DIR__ . "/../../config/ContainerBindings.php";

/** Cargamos variables de entorno */
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ ."/../..");
$dotenv->load();

/* ----------------------------------------------------------------------
| Organizamos las variables que necesitamos
* -----------------------------------------------------------------------
*/
$carro = $container->get(Carro::class);
$envio = $container->get(EnvioVencimientoService::class);

$vencidos = $carro->getProximosAVencer();
$envio->enviar($vencidos);
