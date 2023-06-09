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
        $this->table    = "carro_reg_medicamentos";
        $this->required = [
            "lote",
            "medida",
            "invima",
            "p_activo_concentracion",
            "carro_id",
            "cantidad",
            "forma_farma",
            "vencimiento",
            "presentacion",
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
                "cantidad"  => $data["cantidad"],
                "forma_farma"   => trim($data["forma_farma"]),
                "presentacion"  => trim($data["presentacion"]),
                "vencimiento"   => trim($data["vencimiento"]),
                "p_activo_concentracion"  => trim($data["p_activo_concentracion"])
            ]);

            return true;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Actualiza la info de un medicamento
     *
     * @return int Devuelve la cantidad de filas afectadas
    */
    public function update(int $id, array $data)
    {
        try {
            $this->checkRequired($data);

            $_ = $this->db->update($this->table, [
                "lote"  => trim($data["lote"]),
                "invima"    => trim($data["invima"]),
                "medida"    => trim($data["medida"]),
                "carro_id"  => trim($data["carro_id"]),
                "cantidad"  => $data["cantidad"],
                "forma_farma"   => trim($data["forma_farma"]),
                "presentacion"  => trim($data["presentacion"]),
                "vencimiento"   => trim($data["vencimiento"]),
                "p_activo_concentracion"  => trim($data["p_activo_concentracion"])
            ], [
                "id" => $id
            ]);

            return $_->rowCount();
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Elimina un medicamento.
     *
     * @return int Devuelve la cantidad de filas afectadas
    */
    public function delete(int $id): int
    {
        try {
            $_ = $this->db->delete($this->table, [
                "id" => $id
            ]);

            return $_->rowCount();
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Obtiene todos los medicamentos relacionados a un carro.
    */
    public function getFromCarro(int $carroId): array
    {
        try {
            return $this->db->select($this->table, "*", [
                "carro_id" => $carroId
            ]);
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
