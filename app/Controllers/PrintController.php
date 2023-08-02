<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Auth;
use App\Views;
use App\Models\Apertura;
use Psr\Http\Message\ResponseInterface as Response;

class PrintController
{
    private Auth $auth;
    private Views $view;
    private Apertura $apertura;


    public function __construct(Apertura $apertura, Views $view, Auth $auth)
    {
        $this->auth = $auth;
        $this->view = $view;
        $this->apertura = $apertura;
    }

    /**
     * Genera una vista para que se pueda imprimir el estado de un carro.
    */
    public function printApertura(Response $response, int $aperturaId): Response
    {
        $data = $this->apertura->find($aperturaId);

        $this->view->addAttribute("user", $this->auth->user());
        $this->view->addAttribute("_data", $data);
        $this->view->addAttribute("printDate", fn(string $date) =>
            implode("-", array_reverse(explode("-", $date)))
        );
        $this->view->addAttribute("dateColor", function(string $date) use($data) {
            $diff = ceil((strtotime($date) - strtotime($data["fecha"])) / (3600 * 24));
            // Rojo < 6 meses (180)
            if ($diff < 180) return "text-bg-danger text-black bg-opacity-75";
            // Amarillo > 6 y < 12 (entre 181 y 360)
            if ($diff > 180 && $diff < 360) return "text-bg-warning text-black bg-opacity-75";
            // Verde > 12 meses (361)
            if ($diff > 360) return "text-bg-success text-black bg-opacity-75";
        });

        return $this->view->render($response, "print/apertura.php");
    }
}
