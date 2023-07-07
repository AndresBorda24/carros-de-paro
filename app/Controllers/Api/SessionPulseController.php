<?php
declare(strict_types=1);

namespace App\Controllers\Api;

use App\Auth;
use App\Session;
use Psr\Http\Message\ResponseInterface as Response;

use function App\responseJson;

/**
 * Esta clase esta pensada para evitar que la sesion caduque. La idea es
 * realizar una llamada ajax a este controlador para que inicie la session
 * (session_start) y que asi no se pierda
*/
class SessionPulseController
{
    private Auth $auth;
    private Session $session;

    public function __construct(Session $session, Auth $auth)
    {
        $this->auth = $auth;
        $this->session = $session;
    }

    public function __invoke(Response $response): Response
    {
        return responseJson($response, [
            "status" => $this->session->isActive(),
            "__" => $this->auth->user()->getAreaId()
        ]);
    }
}
