<?php
declare(strict_types=1);

namespace App\Middleware;

use App\Session;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

class StartSessionMiddleware implements MiddlewareInterface
{
    private Session $session;

    public function __construct(Session $session)
    {
        $this->session = $session;
    }

    public function process(Request $request, RequestHandler $handler): Response
    {
        $this->session->start();
        return $handler->handle($request);
    }
}
