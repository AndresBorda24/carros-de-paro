<?php
declare(strict_types=1);

namespace App\Requests;

class DispositivosRequest extends BodyRequest
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
     * Valida que los datos de la solicitud sean correctos. Helper con
     * reglas preestablecidas especificas para el insert.
    */
    public function validateUpdate(array $data): array
    {
        return $this->validate($data, $this->updateRules());
    }

    /**
     * Reglas para la insercion de una nueva Apertura.
    */
    private function insertRules(): array
    {
        return [
            "apertura_id" => "required|numeric",
            "data.lote" => "required",
            "data.desc" => "required",
            "data.marca" => "required",
            "data.invima" => "required",
            "data.riesgo" => "required",
            "data.cantidad" => "required|numeric",
            "data.carro_id" => "required|numeric",
            "data.vida_util" => "required",
            "data.vencimiento" => "required",
            "data.presentacion" => "required",
            "data.new" => "nullable|default:1"
        ];
    }

    private function updateRules(): array
    {
        return $this->insertRules() + [
            "data.id"   => "required|numeric",
            "data.motivo_edicion" => "required",
            "data.new" => "nullable"
        ];
    }
}
