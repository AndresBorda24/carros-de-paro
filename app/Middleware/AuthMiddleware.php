<?php
declare(strict_types = 1);

namespace App\Middleware;

use App\Auth;
use Slim\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class AuthMiddleware implements MiddlewareInterface
{
    private Auth $auth;

    public function __construct(
        Auth $auth
    ) {
        $this->auth = $auth;
    }

    public function process(
        ServerRequestInterface $request,
        RequestHandlerInterface $handler
    ): ResponseInterface {
        if ($user = $this->auth->user()) {
            return $handler->handle($request->withAttribute('user', $user));
        }

        $response = new Response(302);
        return $response->withHeader('Location', '/login');
    }
}
