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
}
