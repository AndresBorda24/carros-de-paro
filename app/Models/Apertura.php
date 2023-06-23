<?php
declare(strict_types=1);

namespace App\Models;

use Medoo\Medoo;

class Apertura
{
    CONST TABLE = "carro_aperturas";

    private Medoo $db;
    private array $required = [
        "carro_id",
        "quien",
        "motivo"
    ];

    public function __construct(Medoo $db)
    {
        $this->db = $db;
    }

    /**
     * Crea el registro de una apertura.
    */
    public function create(array $data): int
    {
        try {
            $this->checkRequired($data);

            $this->db->insert(static::TABLE, [
                "quien"  => $data["quien"],
                "fecha"  => Medoo::raw("CURDATE()"),
                "hora"   => Medoo::raw("CURTIME()"),
                "motivo" => $data["motivo"],
                "carro_id"  => $data["carro_id"],
            ]);

            return (int) $this->db->id();
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Obtiene todos los carros
    */
    public function getAll(): ?array
    {
        try {
            return $this->db->select(static::TABLE, "*");
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Revisa si `$data` tiene los campos requeridos
    */
    private function checkRequired(array $data)
    {
        foreach($this->required as $required) {
            if (! array_key_exists($required, $data)) {
                throw new \Exception("Faltan Campos Requeridos");
            }
        }
    }
}
