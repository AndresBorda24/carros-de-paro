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

        return $this->view->render($response, "print/apertura.php");
    }

    /**
     * Genera una vista para que se pueda imprimir el estado de un carro.
    */
    public function printCurrent(Response $response, int $carroId): Response
    {
        $data = $this->apertura->getLatest($carroId);
        $data["isCurrent"] = 1;

        $this->view->addAttribute("user", $this->auth->user());
        $this->view->addAttribute("_data", $data);
        $this->view->addAttribute("dateColor", $this->getDateColorFunc());
        $this->view->addAttribute("printDate", fn(string $date) =>
            implode("-", array_reverse(explode("-", $date)))
        );

        // $this->view->addAttribute("dateColor", function(string $date) {
        //     $diff = ceil((strtotime($date) - strtotime("now")) / (3600 * 24));

        //     // Rojo < 6 meses (180)
        //     if ($diff < 183) return "text-bg-danger text-black bg-opacity-75";
        //     // Amarillo > 6 y < 12 (entre 181 y 360)
        //     if ($diff >= 183 && $diff <= 365) return "text-bg-warning text-black bg-opacity-75";
        //     // Verde > 12 meses (361)
        //     if ($diff > 365) return "text-bg-success text-black bg-opacity-75";
        // });

        return $this->view->render($response, "print/apertura.php");
    }


    public function printAll(Response $response, string $tipo): Response
    {
        $tipo = \App\Enums\CarroTipo::from(mb_strtoupper($tipo));

        $data = $this->apertura->findAll($tipo);

        $this->view->addAttribute("user", $this->auth->user());
        $this->view->addAttribute("dateColor", $this->getDateColorFunc());
        $this->view->addAttribute("printDate", fn(string $date) =>
            implode("-", array_reverse(explode("-", $date)))
        );

        return $this->view->render($response, "print/aperturas-full.php", [
            "aperturas" => $data
        ]);
    }

    private function getDateColorFunc()
    {
        return function(string $date, ?string $aperturaFecha = null) {
            $diff = ($aperturaFecha === null)
                ? ceil((strtotime($date) - strtotime("now")) / (3600 * 24))
                : ceil((strtotime($date) - strtotime($aperturaFecha)) / (3600 * 24));

            // Rojo < 6 meses (180)
            if ($diff < 183)
                return "text-bg-danger text-black bg-opacity-75";
            // Amarillo > 6 y < 12 (entre 181 y 360)
            if ($diff >= 183 && $diff <= 365)
                return "text-bg-warning text-black bg-opacity-75";
            // Verde > 12 meses (361)
            if ($diff > 365)
                return "text-bg-success text-black bg-opacity-75";
        };
    }
}
