<?php
declare(strict_types=1);

namespace App\Controllers\Api;

use App\Models\Dispositivo;
use App\Services\AlterHistorico;
use App\Services\HistoricoService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use function App\responseJson;

class DispositivoController
{
    private Dispositivo $dispositivo;
    private HistoricoService $historico;
    private AlterHistorico $alterHistorico;

    public function __construct(
        Dispositivo $dispositivo,
        HistoricoService $historico,
        AlterHistorico $alterHistorico
    ) {
        $this->historico = $historico;
        $this->dispositivo = $dispositivo;
        $this->alterHistorico = $alterHistorico;
    }

    public function create(Request $request, Response $response, int $apId): Response
    {
        try {
            $data = $request->getParsedBody();
            $this->dispositivo->create($data);
            $data["id"] = $this->dispositivo->getInsertId();

            $this->alterHistorico->setData($this->dispositivo, $apId);
            $this->alterHistorico->insert($data);

            return responseJson($response, ["id" => $data["id"]]);
        } catch(\Exception $e) {
            return responseJson($response, [
                "status" => false,
                "message"=> $e->getMessage()
            ], 422);
        }
    }

    public function update(
        Request $request,
        Response $response,
        int $id,
        int $apId
    ): Response {
        try {
            $data = $request->getParsedBody();
            $updated = $this->dispositivo->update($id, $data);

            $this->alterHistorico->setData($this->dispositivo, $apId);
            $this->alterHistorico->update($data);

            return responseJson($response, $updated);
        } catch(\Exception $e) {
            return responseJson($response, [
                "status" => false,
                "message"=> $e->getMessage()
            ], 422);
        }
    }

    /**
     * Realiza las inserciones, actualizaciones y eliminaciones correspondientes
     * a los dispositivos de un carro de paro especifico.
    */
    public function updateCarro(
        Request $request,
        Response $response,
        int $carroId
    ): Response
    {
        try {
            $data = $request->getParsedBody();
            $this->historico->store(
                $data,
                $this->dispositivo,
                $carroId
            );

            return responseJson($response, true);
        } catch(\Exception $e) {
            return responseJson($response, [
                "status" => false,
                "error"  => $e->getMessage()
            ], 422);
        }
    }

    public function getFromCarro(Response $response, int $carroId): Response
    {
        try {
            return responseJson(
                $response,
                $this->dispositivo->getFromCarro($carroId)
            );
        } catch(\Exception $e) {
            return responseJson($response, [
                "status" => false,
                "message"=> $e->getMessage()
            ], 422);
        }
    }

    public function delete(Response $response, int $id, int $apId): Response
    {
        try {
            $_ = $this->dispositivo->delete($id);

            $this->alterHistorico->setData($this->dispositivo, $apId);
            $this->alterHistorico->delete($_);

            return responseJson($response, $_);
        } catch(\Exception $e) {
            return responseJson($response, [
                "status" => false,
                "message"=> $e->getMessage()
            ], 422);
        }
    }
}
