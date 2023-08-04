<?php
declare(strict_types=1);

namespace App\Requests;

class AperturaRequest extends BodyRequest
{
    /**
     * Valida que los datos de la solicitud sean correctos. Helper con
     * reglas preestablecidas especificas para el insert.
    */
    public function validateInsert(array $data): array
    {
        return $this->validate($data, $this->insertRules());
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
