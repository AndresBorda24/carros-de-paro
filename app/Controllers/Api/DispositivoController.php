<?php
declare(strict_types=1);

namespace App\Controllers\Api;

use App\Models\Dispositivo;
use App\Services\HistoricoService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use function App\responseJson;

class DispositivoController
{
    private Dispositivo $dispositivo;
    private HistoricoService $historico;

    public function __construct(
        Dispositivo $dispositivo,
        HistoricoService $historico
    ) {
        $this->historico = $historico;
        $this->dispositivo = $dispositivo;
    }

    public function create(Request $request, Response $response): Response
    {
        try {
            $data = $request->getParsedBody();
            $this->dispositivo->create($data);

            return responseJson($response, [
                "id" => $this->dispositivo->getInsertId()
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
                $this->dispositivo->update($id, $data)
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

    public function delete(Response $response, int $id): Response
    {
        try {
            return responseJson(
                $response,
                $this->dispositivo->delete($id)
            );
        } catch(\Exception $e) {
            return responseJson($response, [
                "status" => false,
                "message"=> $e->getMessage()
            ], 422);
        }
    }
}
