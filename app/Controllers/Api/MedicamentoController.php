<?php
declare(strict_types=1);

namespace App\Controllers\Api;

use App\Models\Medicamento;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use function App\responseJson;

class MedicamentoController
{
    private Medicamento $medicamento;

    public function __construct(Medicamento $medicamento)
    {
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
}
