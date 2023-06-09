<?php
declare(strict_types=1);

namespace App\Controllers\Api;

use App\Models\Medicamento;
use App\Services\RegistroService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use function App\responseJson;

class MedicamentoController
{
    private RegistroService $reg;
    private Medicamento $medicamento;

    public function __construct(Medicamento $medicamento, RegistroService $reg)
    {
        $this->reg = $reg;
        $this->medicamento = $medicamento;
    }

    public function create(Request $request, Response $response): Response
    {
        try {
            // Insercion del Medicamento
            $data = $request->getParsedBody();
            $this->medicamento->create($data);
            $id = $this->medicamento->getInsertId();

            // Insercion en el Registro
            $this->reg->medicamento(
                $this->medicamento->findForReg($id),
                \App\Models\Registro::INSERT,
                $data
            );

            return responseJson($response, ["id" => $id]);
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
            // Update
            $data = $request->getParsedBody();
            $rows = $this->medicamento->update($id, $data);

            // Insercion en el Registro
            $this->reg->medicamento(
                $this->medicamento->findForReg($id),
                \App\Models\Registro::UPDATE,
                $data
            );

            return responseJson($response, $rows);
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

    public function delete(Response $response, int $id): Response
    {
        try {
            $data = $this->medicamento->findForReg($id);
            $rows = $this->medicamento->delete($id);

            // Insercion en el Registro
            $this->reg->medicamento(
                $data,
                \App\Models\Registro::DELETE
            );
            return responseJson($response, $rows);
        } catch(\Exception $e) {
            return responseJson($response, [
                "status" => false,
                "message"=> $e->getMessage()
            ], 422);
        }
    }
}
