<?php
declare(strict_types=1);

namespace App\Controllers\Api;

use App\Models\Dispositivo;
use App\Services\AlterHistorico;
use App\Requests\DispositivosRequest;
use App\Requests\Exceptions\RequestException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use function App\responseJson;
use function App\responseError;

class DispositivoController
{
    private Dispositivo $dispositivo;
    private AlterHistorico $alterHistorico;
    private DispositivosRequest $validator;

    public function __construct(
        Dispositivo $dispositivo,
        AlterHistorico $alterHistorico,
        DispositivosRequest $validator
    ) {
        $this->dispositivo = $dispositivo;
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
            $data["id"] = $this->dispositivo->create($data);

            $this->alterHistorico
                ->setData($this->dispositivo, (int) $aperturaId)
                ->insert($data);

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

            $_ = $this->dispositivo->update($id, $data);

            $this->alterHistorico
                ->setData($this->dispositivo, $aperturaId)
                ->update($data);

            return responseJson($response, [
                "status" => true,
                "__ctrl" => $_
            ]);
        } catch(\Exception|RequestException $e) {
            return responseError($response, $e);
        }
    }

    public function getFromCarro(Response $response, int $carroId): Response
    {
        try {
            return responseJson(
                $response,
                $this->dispositivo->getFromCarro($carroId)
            );
        } catch(\Exception|RequestException $e) {
            return responseError($response, $e);
        }
    }

    public function delete(Request $request, Response $response, int $id): Response
    {
        try {
            $body = $request->getParsedBody();
            $aperturaId = (int) $body["apertura_id"];

            $_ = $this->dispositivo->delete($id);

            $this->alterHistorico
                ->setData($this->dispositivo, $aperturaId)
                ->delete($id);

            return responseJson($response, [
                "status" => true,
                "__ctrl" => $_
            ]);
        } catch(\Exception|RequestException $e) {
            return responseError($response, $e);
        }
    }
}
