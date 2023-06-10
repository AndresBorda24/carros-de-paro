<?php
declare(strict_types=1);

namespace App\Controllers\Api;

use App\Models\Medicamento;
use App\Services\HistoricoService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use function App\responseJson;

class MedicamentoController
{
    private Medicamento $medicamento;
    private HistoricoService $historico;

    public function __construct(
        Medicamento $medicamento,
        HistoricoService $historico
    ) {
        $this->historico = $historico;
        $this->medicamento = $medicamento;
    }

    public function create(Request $request, Response $response): Response
    {
        try {
            $data = $request->getParsedBody();
            $this->medicamento->create($data);

            return responseJson($response, [
                "id" => $this->medicamento->getInsertId()
            ]);
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
        int $id
    ): Response {
        try {
            $data = $request->getParsedBody();

            return responseJson(
                $response,
                $this->medicamento->update($id, $data)
            );
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
                HistoricoService::MEDICAMENTO,
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

    public function delete(Response $response, int $id): Response
    {
        try {
            return responseJson(
                $response,
                $this->medicamento->delete($id)
            );
        } catch(\Exception $e) {
            return responseJson($response, [
                "status" => false,
                "message"=> $e->getMessage()
            ], 422);
        }
    }
}
