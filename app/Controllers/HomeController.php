<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Views;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class HomeController
{
    private Views $views;

    public function __construct(Views $views)
    {
        $this->views = $views;
    }

    public function index(Request $request, Response $response): Response
    {
        $this->views->setRouteContext($request);
        return $this->views->render($response, "carro.php");
    }

    public function estantes(Request $request, Response $response): Response
    {
        $this->views->setRouteContext($request);
        return $this->views->render($response, "carro.php");
    }

    public function kits(Request $request, Response $response): Response
    {
        $this->views->setRouteContext($request);
        return $this->views->render($response, "carro.php");
    }

    public function buscarHistorico(Request $request, Response $response): Response
    {
        $this->views->setRouteContext($request);
        return $this->views->render($response, "buscar-historico.php");
    }
}
