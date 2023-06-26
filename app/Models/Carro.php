<?php
declare(strict_types=1);

namespace App\Models;

use Medoo\Medoo;

class Carro
{
    public CONST TABLE = "carros";

    private Medoo $db;
    private array $required = [
        "nombre",
        "ubicacion"
    ];

    public function __construct(Medoo $db)
    {
        $this->db = $db;
    }

    /**
     * Crea un Nuevo Carro de Paro
    */
    public function create(array $data): bool
    {
        try {
            $this->checkRequired($data);

            $this->db->insert(static::TABLE, [
                "nombre"    => trim($data["nombre"]),
                "ubicacion" => trim($data["ubicacion"])
            ]);

            return true;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Actualiza un Nuevo Carro de Paro
    */
    public function update(int $id, array $data): int
    {
        try {
            $this->checkRequired($data);

            $_ = $this->db->update(static::TABLE, [
                "nombre"    => trim($data["nombre"]),
                "ubicacion" => trim($data["ubicacion"])
            ], [
                "id" => $id
            ]);

            return $_->rowCount();
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Elimina un dispositivo.
     *
     * @return int Devuelve la cantidad de filas afectadas
    */
    public function delete(int $id): int
    {
        try {
            $_ = $this->db->delete(static::TABLE, [
                "id" => $id
            ]);

            return $_->rowCount();
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
