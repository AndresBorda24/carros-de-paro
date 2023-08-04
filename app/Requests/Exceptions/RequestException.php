<?php
declare(strict_types=1);

namespace App\Requests\Exceptions;

use Exception;

class RequestException extends Exception
{
    private array $requestErrors;

    public function __construct(array $errors, ?string $message = null)
    {
        $this->requestErrors = $errors;
        $message ??= "Invalid body request.";

        parent::__construct($message, 24001);
    }

    public function getErrors(): array
    {
        return $this->requestErrors;
    }
}
