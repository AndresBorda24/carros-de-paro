<?php
declare(strict_types=1);

namespace App\Controllers\Api;

use App\Models\Carro;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use function App\responseJson;

class CarroController
{
    private Carro $carro;

    public function __construct(Carro $carro)
    {
        $this->carro = $carro;
    }

    public function create(Request $request, Response $response): Response
    {
        try {
            $data = $request->getParsedBody();

            $this->carro->create([
                "nombre" => $data["nombre"],
                "ubicacion" => $data["ubicacion"]
            ]);

            return responseJson($response, [
                "id" => $this->carro->getInsertId()
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
                $this->carro->update($id, $data)
            );
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
