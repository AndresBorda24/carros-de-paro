<?php
declare(strict_types=1);

namespace App\Controllers\Api;

use App\Auth;
use Medoo\Medoo;
use App\Models\Apertura;
use App\Models\Carro;
use App\Models\Dispositivo;
use App\Models\Medicamento;
use App\Services\HistoricoService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use function App\responseJson;

class CarroController
{
    private Medoo $db;
    private Auth $auth;
    private HistoricoService $historicoService;

    public function __construct(
        Medoo $db,
        Auth $auth,
        HistoricoService $historicoService
    ) {
        $this->db = $db;
        $this->auth = $auth;
        $this->historicoService = $historicoService;
    }

    public function create(Request $request, Response $response): Response
    {
        try {
            $data = $request->getParsedBody();
            $carro = new Carro($this->db);

            $carro->create([
                "nombre" => $data["nombre"],
                "ubicacion" => $data["ubicacion"],
                "tipo" => $data["tipo"]
            ]);

            return responseJson($response, [
                "id" => $carro->getInsertId()
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
            $carro = new Carro($this->db);

            return responseJson(
                $response,
                $carro->update($id, $data)
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
            $carro = new Carro($this->db);

            return responseJson($response, $carro->delete($id));
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
            $carro = new Carro($this->db);

            return responseJson(
                $response,
                $carro->getAll(\App\Enums\CarroTipo::CARRO())
            );
        } catch(\Exception $e) {
            return responseJson($response, [
                "status" => false,
                "message"=> $e->getMessage()
            ], 422);
        }
    }

    /**
     * Retorna un array con todos los estantes.
    */
    public function getAllEstantes(Response $response): Response
    {
        try {
            $carro = new Carro($this->db);

            return responseJson(
                $response,
                $carro->getAll(\App\Enums\CarroTipo::ESTANTE())
            );
        } catch(\Exception $e) {
            return responseJson($response, [
                "status" => false,
                "message"=> $e->getMessage()
            ], 422);
        }
    }

    /**
     * Regresa la informacion relacionada con alguna apertura de carro.
    */
    public function findApertura(Response $response, int $aperturaId): Response
    {
        try {
            $apertura = new Apertura($this->db);

            return responseJson($response, $apertura->find($aperturaId));
        } catch(\Exception $e) {
            return responseJson($response, [
                "status" => false,
                "message"=> $e->getMessage()
            ], 422);
        }
    }

    /**
     * Obtiene informacion basica sobre las aperturas realizadas a un carro en
     * especifico.
    */
    public function getAperturas(Response $response, int $id): Response
    {
        try {
            $apertura = new Apertura($this->db);

            return responseJson($response, $apertura->getFromCarro($id));
        } catch(\Exception $e) {
            return responseJson($response, [
                "status" => false,
                "message"=> $e->getMessage()
            ], 422);
        }
    }

    /**
     * Se encarga de registrar una apertura. Guarda los medicamentos y
     * dispositivos. Ademas de guardar informacion extra como quien y
     * cuando realizo la modificacion.
    */
    public function saveApertura(
        Request $request,
        Response $response,
        int $id
    ) {
        try {
            $data = $request->getParsedBody();
            $error = null;

            $this->db->action(function() use ($id, $data, &$error) {
                try {
                    $apertura = new Apertura($this->db);
                    // Creamos la apertura
                    $aperturaId = $apertura->create([
                        "carro_id" => $id,
                        "quien"    => $this->auth->user()->getId(),
                        "motivo"   => $data["motivo"]
                    ]);

                    // Guardamos los Medicametos
                    $this->historicoService->store(
                        $data["medicamentos"],
                        new Medicamento($this->db),
                        $aperturaId,
                        $id
                    );

                    // Guardamos los Dispositivos
                    $this->historicoService->store(
                        $data["dispositivos"],
                        new Dispositivo($this->db),
                        $aperturaId,
                        $id
                    );

                    return true;
                } catch(\Exception $e){
                    $error = $e;
                    return false;
                }
            });

            if ($error) throw $error;

            return responseJson(
                $response,
                true
            );
        } catch(\Exception $e) {
            return responseJson($response, [
                "status" => false,
                "message"=> $e->getMessage()
            ], 422);
        }
    }
}
