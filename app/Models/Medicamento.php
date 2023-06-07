<?php
declare(strict_types=1);

namespace App\Models;

use Medoo\Medoo;

class Medicamento
{
    private Medoo $db;
    private string $table;
    private array $required;

    public function __construct(Medoo $db)
    {
        $this->db       = $db;
        $this->table    = "reg_medicamentos";
        $this->required = [
            "lote",
            "medida",
            "invima",
            "p_activo",
            "carro_id",
            "cantidad",
            "forma_farma",
            "vencimiento",
            "presentacion",
            "concentracion",
        ];
    }

    /** Crea un Nuevo Carro de Paro */
    public function create(array $data): bool
    {
        try {
            $this->checkRequired($data);

            $this->db->insert($this->table, [
                "lote"  => trim($data["lote"]),
                "invima"    => trim($data["invima"]),
                "medida"    => trim($data["medida"]),
                "carro_id"  => trim($data["carro_id"]),
                "p_activo"  => trim($data["p_activo"]),
                "cantidad"  => $data["cantidad"],
                "forma_farma"   => trim($data["forma_farma"]),
                "presentacion"  => trim($data["presentacion"]),
                "vencimiento"   => trim($data["vencimiento"]),
                "concentracion" => trim($data["concentracion"])
            ]);

            return true;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function getInsertId(): int
    {
        return (int) $this->db->id();
    }

    /** Revisa si `$data` tiene los campos requeridos */
    private function checkRequired(array $data)
    {
        foreach($this->required as $required) {
            if (! array_key_exists($required, $data)) {
                throw new \Exception("Faltan Campos Requeridos");
            }
        }
    }
}
