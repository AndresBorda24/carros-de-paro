<?php
declare(strict_types=1);

namespace App\Controllers\Api;

use App\Models\Carro;
use App\Services\RegistroService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use function App\responseJson;

class CarroController
{
    private Carro $carro;
    private RegistroService $reg;

    public function __construct(Carro $carro, RegistroService $reg)
    {
        $this->reg = $reg;
        $this->carro = $carro;
    }

    public function create(Request $request, Response $response): Response
    {
        try {
            // insert
            $data = $request->getParsedBody();
            $this->carro->create($data);
            $id = $this->carro->getInsertId();

            // registro
            $this->reg->carro(
                $this->carro->findForReg($id),
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
            $rows = $this->carro->update($id, $data);

            // Registro
            $this->reg->carro(
                $this->carro->findForReg($id),
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

    public function delete(Response $response, int $id): Response
    {
        try {
            $data = $this->carro->findForReg($id);
            $rows = $this->carro->delete($id);

            $data["carro_id"] = null;

            // Registro
            $this->reg->carro(
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

    /**
     * Retorna un array con todos los carros.
    */
    public function getAll(Response $response): Response
    {
        try {
            return responseJson($response, $this->carro->getAll());
        } catch(\Exception $e) {
            return responseJson($response, [
                "status" => false,
                "message"=> $e->getMessage()
            ], 422);
        }
    }
}
