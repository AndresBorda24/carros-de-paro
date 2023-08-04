<?php
declare(strict_types=1);

namespace App\Controllers\Api;

use App\Models\Medicamento;
use App\Services\AlterHistorico;
use App\Requests\MedicamentoRequest;
use App\Requests\Exceptions\RequestException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use function App\responseJson;
use function App\responseError;

class MedicamentoController
{
    private Medicamento $medicamento;
    private AlterHistorico $alterHistorico;
    private MedicamentoRequest $validator;

    public function __construct(
        Medicamento $medicamento,
        AlterHistorico $alterHistorico,
        MedicamentoRequest $validator
    ) {
        $this->medicamento = $medicamento;
        $this->alterHistorico = $alterHistorico;
        $this->validator = $validator;
    }

    public function create(Request $request, Response $response): Response
    {
        try {
            list(
                "data" => $data,
                "apertura_id" => $aperturaId
            ) = $this->validator->validateInsert($request->getParsedBody());

            $data["id"] = $this->medicamento->create($data);;

            $this->alterHistorico
                ->setData($this->medicamento, (int) $aperturaId)
                ->insert($data["data"]);

            return responseJson($response, [
                "status" => true,
                "__id"   => $data["id"]
            ]);
        } catch(\Exception|RequestException $e) {
            return responseError($response, $e);
        }
    }

    public function update(Request $request, Response $response, int $id): Response
    {
        try {
            list(
                "data" => $data,
                "apertura_id" => $aperturaId
            )  = $this->validator->validateUpdate($request->getParsedBody());
            $_ = $this->medicamento->update($id, $data);

            $this->alterHistorico
                ->setData($this->medicamento, $aperturaId)
                ->update($data);

            return responseJson($response, [
                "status" => true,
                "__ctrl" => $_
            ]);
        } catch(\Exception|RequestException $e) {
            return responseError($response, $e);
        }
    }

    public function delete(Request $request, Response $response, int $id): Response
    {
        try {
            $body = $request->getParsedBody();
            $aperturaId = (int) $body["apertura_id"];

            $_ = $this->medicamento->delete($id);
            $this->alterHistorico
                ->setData($this->medicamento, $aperturaId)
                ->delete($id);

            return responseJson($response, [
                "status" => true,
                "__ctrl" => $_
            ]);
        } catch(\Exception $e) {
            return responseError($response, $e);
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
