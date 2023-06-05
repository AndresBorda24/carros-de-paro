<?php
declare(strict_types=1);

namespace App\Models;

use Medoo\Medoo;

class Carro
{
    private Medoo $db;
    private string $table;
    private array $required = [
        "nombre",
        "ubicacion"
    ];

    public function __construct(Medoo $db)
    {
        $this->db = $db;
        $this->table = "carros";
    }

    /** Crea un Nuevo Carro de Paro */
    public function create(array $data): bool
    {
        try {
            $this->checkRequired($data);

            $this->db->insert($this->table, [
                "nombre"    => trim($data["nombre"]),
                "ubicacion" => trim($data["ubicacion"])
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
