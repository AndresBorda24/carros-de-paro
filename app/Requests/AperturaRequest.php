<?php
declare(strict_types=1);

namespace App\Requests;

use App\Requests\Exceptions\RequestException;
use Rakit\Validation\Validator;

class AperturaRequest
{
    private Validator $validator;

    public function __construct(Validator $validator)
    {
        $this->validator = $validator;
    }

    /**
     * Valida que los datos de la solicitud sean correctos. Helper con
     * reglas preestablecidas especificas para el insert.
    */
    public function validateInsert(array $data): array
    {
        return $this->validate($data, $this->insertRules());
    }

    /**
     * Validata que $data cumpla las $rules.
     *
     * @throws \App\Requests\Exceptions\RequestException
     * @return array Datos validados.
    */
    private function validate(array $data, array $rules): array
    {
        $validation = $this->validator->validate($data, $rules);

        if ($validation->fails()) {
            throw new RequestException($validation->errors()->firstOfAll());
        }

        return $validation->getValidatedData();
    }

    /**
     * Reglas para la insercion de una nueva Apertura.
    */
    private function insertRules(): array
    {
        return [
            "carro_id" => "required|numeric",
            "motivo"   => "required",
            "before"   => "required|array",
            "before.medicamentos" => "required|array",
            "before.dispositivos" => "required|array"
        ];
    }
}
