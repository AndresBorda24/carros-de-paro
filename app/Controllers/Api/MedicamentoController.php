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

    public function create(Request $request, Response $response): Response
    {
        try {
            $body = $request->getParsedBody();
            $data = $body["data"];
            $aperturaId = (int) $body["apertura_id"];

            $this->medicamento->create($data);
            $data["id"] = $this->medicamento->getInsertId();

            $this->alterHistorico->setData($this->medicamento, $aperturaId);
            $this->alterHistorico->insert($data);

            return responseJson($response, [
                "status" => true,
                "__id"   => $data["id"]
            ]);
        } catch(\Exception $e) {
            return responseJson($response, [
                "status" => false,
                "message"=> $e->getMessage()
            ], 422);
        }
    }

    public function update(Request $request, Response $response, int $id): Response
    {
        try {
            $body = $request->getParsedBody();
            $data = $body["data"];
            $aperturaId = (int) $body["apertura_id"];

            $_ = $this->medicamento->update($id, $data);

            $this->alterHistorico->setData($this->medicamento, $aperturaId);
            $this->alterHistorico->update($data);

            return responseJson($response, [
                "status" => true,
                "__ctrl" => $_
            ]);
        } catch(\Exception $e) {
            return responseJson($response, [
                "status" => false,
                "message"=> $e->getMessage()
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

    public function delete(Request $request, Response $response, int $id): Response
    {
        try {
            $body = $request->getParsedBody();
            $aperturaId = (int) $body["apertura_id"];

            $_ = $this->medicamento->delete($id);
            $this->alterHistorico->setData($this->medicamento, $aperturaId);
            $this->alterHistorico->delete($id);

            return responseJson($response, [
                "status" => true,
                "__ctrl" => $_
            ]);
        } catch(\Exception $e) {
            return responseJson($response, [
                "status" => false,
                "message"=> $e->getMessage()
            ], 422);
        }
    }
}
