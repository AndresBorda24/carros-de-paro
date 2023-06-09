<?php
declare(strict_types=1);

namespace App\Controllers\Api;

use App\Models\Dispositivo;
use App\Services\RegistroService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use function App\responseJson;

class DispositivoController
{
    private RegistroService $reg;
    private Dispositivo $dispositivo;

    public function __construct(Dispositivo $dispositivo, RegistroService $reg)
    {
        $this->reg = $reg;
        $this->dispositivo = $dispositivo;
    }

    public function create(Request $request, Response $response): Response
    {
        try {
            // Insercion
            $data = $request->getParsedBody();
            $this->dispositivo->create($data);
            $id = $this->dispositivo->getInsertId();

            // Registro
            $this->reg->dispositivo(
                $this->dispositivo->findForReg($id),
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
            $rows = $this->dispositivo->update($id, $data);

            // Registro
            $this->reg->dispositivo(
                $this->dispositivo->findForReg($id),
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
                $this->dispositivo->getFromCarro($carroId)
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
            $data = $this->dispositivo->findForReg($id);
            $rows = $this->dispositivo->delete($id);

            // Registro
            $this->reg->dispositivo(
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
