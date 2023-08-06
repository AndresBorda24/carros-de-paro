<?php
declare(strict_types=1);

namespace App\Controllers\Api;

use App\Models\Apertura;
use App\Contracts\UserInterface;
use App\Requests\AperturaRequest;
use App\Requests\Exceptions\RequestException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use function App\responseJson;
use function App\responseError;

class AperturasController
{
    private Apertura $apertura;
    private AperturaRequest $validator;

    public function __construct(Apertura $apertura, AperturaRequest $validator)
    {
        $this->apertura = $apertura;
        $this->validator = $validator;
    }

    public function store(
        Request $request,
        Response $response,
        UserInterface $user
    ): Response {
        try {
            $body = $request->getParsedBody();
            $data = $this->validator->validateInsert($body);
            $data += ["quien" => $user->getId()];

            $id = $this->apertura->create($data);
            $this->apertura->createHistorico($id, $data["before"]);

            return responseJson($response, [
                "status" => true,
                "__id"   => $id
            ]);
        } catch(\Exception|RequestException $e) {
            isset($id) ? $this->apertura->delete($id) : null;
            return responseError($response, $e);
        }
    }

    public function update(Request $request, Response $response, int $id): Response
    {
        try {
            $data = $this
                ->validator
                ->validateUpdate($request->getParsedBody());

            return responseJson($response, [
                "status" => true,
                "__ctrl" => $this->apertura->update($id, $data)
            ]);
        } catch(\Exception $e) {
            return responseError($response, $e);
        }
    }
}
