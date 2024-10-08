<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Auth;
use App\Views;
use App\Models\Apertura;
use App\Services\AperturaToExcelService;
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
    public function printApertura(Response $response, int $aperturaId, ?int $current): Response
    {
        $data = ($current === null)
            ? $this->apertura->find($aperturaId)
            : $this->apertura->getLatest($aperturaId);

        $compDate = ($current === null) ? $data["fecha"] : null;

        return $this->view->render($response, "print/apertura.php", [
            "data" => $data,
            "user" => $this->auth->user(),
            "compDate" => $compDate,
            "getDateColor" =>  $this->getDateColorFunc(),
            "printDate" => fn(string $date) => implode(
                "-", array_reverse(explode("-", $date))
            )
        ]);
    }

    public function printAll(Response $response, string $tipo): Response
    {
        $tipo = \App\Enums\CarroTipo::from(mb_strtoupper($tipo));
        $data = $this->apertura->findAll($tipo);

        $this->view->addAttribute("printDate", fn(string $date) =>
            implode("-", array_reverse(explode("-", $date)))
        );

        return $this->view->render($response, "print/aperturas-full.php", [
            "data" => $data,
            "user" => $this->auth->user(),
            "compDate" => null,
            "aperturas" => $data,
            "getDateColor" =>  $this->getDateColorFunc(),
            "printDate" => fn(string $date) => implode(
                "-", array_reverse(explode("-", $date))
            )
        ]);
    }

    public function toExcel(Response $response, AperturaToExcelService $service, string $tipo): Response
    {
        $tipo = \App\Enums\CarroTipo::from(mb_strtoupper($tipo));

        $service->loadAperturas($tipo);
        $service->setDispositivosSheet();
        $service->setMedicamentosSheet();
        [$fileName, $filePath] = $service->generateExcelIndividual();
        $fileName = strtolower("excel-general-{$tipo->getKey()}.xlsx");


        $response = $response
            ->withHeader('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet')
            ->withHeader('Content-Disposition', "attachment; filename=$fileName")
            ->withAddedHeader('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
            ->withHeader('Cache-Control', 'post-check=0, pre-check=0')
            ->withHeader('Pragma', 'no-cache')
            ->withBody((new \Slim\Psr7\Stream(fopen($filePath, 'rb'))));

        return $response;
    }

    public function toExcelIndividual(Response $response, AperturaToExcelService $service, int $carroId): Response
    {
        $service->loadApertura($carroId);
        $service->setDispositivosSheet();
        $service->setMedicamentosSheet();
        [$fileName, $filePath] = $service->generateExcelIndividual();
        $fileName = "excel-individual-$carroId.xlsx";

        $response = $response
            ->withHeader('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet')
            ->withHeader('Content-Disposition', "attachment; filename=$fileName")
            ->withAddedHeader('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
            ->withHeader('Cache-Control', 'post-check=0, pre-check=0')
            ->withHeader('Pragma', 'no-cache')
            ->withBody((new \Slim\Psr7\Stream(fopen($filePath, 'rb'))));

        return $response;
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
