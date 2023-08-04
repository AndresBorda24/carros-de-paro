<?php
declare(strict_types=1);

namespace App\Controllers\Api;

use App\Models\Apertura;
use App\Contracts\UserInterface;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use function App\responseJson;

class AperturasController
{
    private Apertura $apertura;

    public function __construct(Apertura $apertura)
    {
        $this->apertura = $apertura;
    }

    public function store(
        Request $request,
        Response $response,
        UserInterface $user
    ): Response {
        try {
            $data = $request->getParsedBody();
            $id = $this->apertura->create($data + ["quien" => $user->getId()]);

            if (! $this->apertura->createHistorico($id, $data["before"])) {
                $this->apertura->delete($id);
                throw new \Exception("No se ha podido guardar la apertura.");
            }

            return responseJson($response, [
                "status" => true,
                "__id"   => $id
            ]);
        } catch(\Exception $e) {
            isset($id) ? $this->apertura->delete($id) : null;

            return responseJson($response, [
                "status" => false,
                "error"  => $e->getMessage()
            ], 422);
        }
    }
}
