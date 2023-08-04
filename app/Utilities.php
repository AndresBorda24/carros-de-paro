<?php
declare(strict_types=1);

namespace App;

use App\Requests\Exceptions\RequestException;
use Psr\Http\Message\ResponseInterface as Response;

if (! function_exists('App\responseJson')) {
    /**
     * Da formato a la respuesta para devolverla como JSON
    */
    function responseJson(
        Response $response,
        $data,
        int $statusCode = 201
    ): Response {
        $payload = json_encode(
            $data,
            JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_QUOT |
            JSON_HEX_APOS | JSON_THROW_ON_ERROR
        );
        $response->getBody()->write($payload);
        return $response
            ->withHeader("Content-Type", "application/json")
            ->withStatus($statusCode);
    }
}

if (! function_exists('App\trimUtf8')) {
    /**
     * Convierte el texto en utf8 y quita los espacios en blanco
    */
    function trimUtf8(string $str): string
    {
        return trim(
            mb_convert_encoding($str, 'UTF-8')
        );
    }
}

if (! function_exists('App\responseError')) {
    /**
     *  Helper para retornar una respuesta de error y que esta pueda
     * deberse a un error del body del request
    */
    function responseError(Response $response, \Exception $e): Response
    {
        $data =  [
            "status" => false,
            "error"  => $e->getMessage(),
        ];

        if ($e instanceof RequestException) {
            $data["fields"] = $e->getErrors();
        }

        return responseJson($response, $data, 422);
    }
}
