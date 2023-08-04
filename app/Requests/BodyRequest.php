<?php
declare(strict_types=1);

namespace App\Requests;

use Rakit\Validation\Validator;
use App\Requests\Exceptions\RequestException;

class BodyRequest
{
    private Validator $validator;

    public function __construct(Validator $validator)
    {
        $this->validator = $validator;
    }

    /**
     * Validata que $data cumpla las $rules.
     *
     * @throws \App\Requests\Exceptions\RequestException
     * @return array Datos validados.
    */
    protected function validate(array $data, array $rules): array
    {
        $validation = $this->validator->validate($data, $rules);

        if ($validation->fails()) {
            throw new RequestException($validation->errors()->firstOfAll());
        }

        return $validation->getValidatedData();
    }
}
