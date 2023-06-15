<?php
declare(strict_types=1);

namespace App\Controllers\Api;

use App\Models\Historico;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use function App\responseJson;

class HistoricoController
{
    private Historico $historico;

    public function __construct(Historico $historico)
    {
        $this->historico = $historico;
    }

    public function getList(Response $response, int $carroId): Response
    {
        try {
            $data = $this->historico->getListFromCarro($carroId);

            return responseJson($response, $data);
        } catch(\Exception $e) {
            return responseJson($response, [
                "status" => false,
                "error"  => $e->getMessage()
            ], 422);
        }
    }

    public function getHistorico(Response $response, int $id): Response
    {
        try {
            return responseJson(
                $response,
                $this->historico->find($id)
            );
        } catch(\Exception $e) {
            return responseJson($response, [
                "status" => false,
                "error"  => $e->getMessage()
            ], 422);
        }
    }

    public function searchHistorico(Request $request, Response $response): Response
    {
        try {
            $_ = $request->getQueryParams();

            return responseJson(
                $response,
                $this->historico->search($_["model"], $_["field"], $_["query"])
            );
        } catch(\Exception $e) {
            return responseJson($response, [
                "status" => false,
                "error"  => $e->getMessage()
            ], 422);
        }
    }
}
