<?php
declare(strict_types=1);

namespace App\Models;

use Medoo\Medoo;

class Historico
{
    private Medoo $db;
    private string $table;
    private array $required = [
        "after",
        "model",
        "quien",
        "before",
        "carro_id",
    ];


    public function __construct(Medoo $db)
    {
        $this->db = $db;
        $this->table = "carro_historico";
    }

    /** Crea un historico */
    public function create(array $data): bool
    {
        try {
            $this->checkRequired($data);

            $this->db->insert($this->table, [
                "model" => $data["model"],
                "quien" => $data["quien"],
                "fecha" => Medoo::raw("CURDATE()"),
                "hora"  => Medoo::raw("CURTIME()"),
                "carro_id"  => $data["carro_id"],
                "before[JSON]" => $data["before"],
                "after[JSON]"  => $data["after"],
            ]);

            return true;
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
            return $this->db->select($this->table, "*");
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
