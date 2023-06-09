<?php
declare(strict_types=1);

namespace App\Controllers\Api;

use App\Models\Registro;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use function App\responseJson;

class RegistroController
{
    private Registro $registro;

    public function __construct(Registro $registro)
    {
        $this->registro = $registro;
    }

    public function getReg(Request $request, Response $response, int $carroId): Response
    {
        try {
            $_ = $this->getDates($request);

            return responseJson(
                $response,
                $this->registro->getReg($carroId, $_["start"], $_["end"])
            );
        } catch(\Exception $e) {
            return responseJson($response, [
                "status"  => false,
                "message" => $e->getMessage()
            ], 422);
        }
    }

    /**
     * Obtiene las fechas de la query string. Si no existen, toma las fechas
     * de la ultima semana.
    */
    private function getDates(Request $request): array
    {
        $query = $request->getQueryParams();

        $start = array_key_exists("start", $query)
            ? date("Y-m-d", strtotime($query["start"]))
            : date("Y-m-d", strtotime('-1 week'));

        $end = array_key_exists("end", $query)
            ? date("Y-m-d", strtotime($query["end"]))
            : date("Y-m-d", time());

        return [
            "start" => $start,
            "end"   => $end
        ];
    }
}
