<?php
declare(strict_types=1);

namespace App\Controllers\Api;

use App\Models\Medicamento;
use App\Services\AlterHistorico;
use App\Services\HistoricoService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use function App\responseJson;

class MedicamentoController
{
    private Medicamento $medicamento;
    private HistoricoService $historico;
    private AlterHistorico $alterHistorico;

    public function __construct(
        Medicamento $medicamento,
        HistoricoService $historico,
        AlterHistorico $alterHistorico
    ) {
        $this->historico = $historico;
        $this->medicamento = $medicamento;
        $this->alterHistorico = $alterHistorico;
    }

    public function create(Request $request, Response $response, int $apId): Response
    {
        try {
            $data = $request->getParsedBody();
            $this->medicamento->create($data);
            $data["id"] = $this->medicamento->getInsertId();
            $this->alterHistorico->setData($this->medicamento, $apId);
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
            $_ = $this->medicamento->update($id, $data);

            $this->alterHistorico->setData($this->medicamento, $apId);
            $this->alterHistorico->update($data);

            return responseJson($response, $_);
        } catch(\Exception $e) {
            return responseJson($response, [
                "status" => false,
                "message"=> $e->getMessage()
            ], 422);
        }
    }


    /**
     * Realiza las inserciones, actualizaciones y eliminaciones correspondientes
     * a los medicamentos de un carro de paro especifico. `carro_id` debe estar
     * en `$data`
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
                $this->medicamento,
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
                $this->medicamento->getFromCarro($carroId)
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
            $_ = $this->medicamento->delete($id);
            $this->alterHistorico->setData($this->medicamento, $apId);
            $this->alterHistorico->delete($id);

            return responseJson($response, $_);
        } catch(\Exception $e) {
            return responseJson($response, [
                "status" => false,
                "message"=> $e->getMessage()
            ], 422);
        }
    }
}
