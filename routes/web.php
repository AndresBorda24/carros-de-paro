<?php
declare(strict_types=1);

use App\Views;
use Psr\Http\Message\ResponseInterface;
use Slim\App;

function loadWebRoutes(App $app) {
    $app->get("/", function(ResponseInterface $response) use ($app){
        $views = $app->getContainer()->get(Views::class);

        return $views->render($response, "index.php");
    });
}

