<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Views;
use Psr\Http\Message\ResponseInterface as Response;

class HomeController
{
    private Views $views;

    public function __construct(Views $views)
    {
        $this->views = $views;
    }

    public function index(Response $response): Response
    {
        return $this->views->render($response, "carro.php");
    }

    public function buscarHistorico(Response $response): Response
    {
        return $this->views->render($response, "buscar-historico.php");
    }
}
