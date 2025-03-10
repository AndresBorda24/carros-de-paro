<?php
declare(strict_types=1);

namespace App\Models;

use Medoo\Medoo;
use App\Contracts\ModelInterface;

class Dispositivo implements ModelInterface
{
    public const MODEL = "Dispositivo";

    private Medoo $db;
    private string $table;

    public function __construct(Medoo $db)
    {
        $this->db    = $db;
        $this->table = "carro_reg_dispositivos";
    }

    /**
     * Devuelve el valor de la constante model. Util para los campos `model` en
     * la base de datos.
    */
    public function getModel(): string
    {
        return static::MODEL;
    }

    /** Crea un Nuevo Carro de Paro */
    public function create(array $data): int
    {
        try {
            $this->db->insert($this->table, [
                "lote" => trim($data["lote"]),
                "desc" => trim($data["desc"]),
                "marca" => trim($data["marca"]),
                "serie" => @$data["serie"],
                "invima" => trim($data["invima"]),
                "riesgo" => trim($data["riesgo"]),
                "cantidad" => $data["cantidad"],
                "carro_id" => trim((string) $data["carro_id"]),
                "vida_util" => trim($data["vida_util"]),
                "vencimiento" => $data["vencimiento"],
                "presentacion" => trim($data["presentacion"]),
            ]);

            return $this->getInsertId();
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Actualiza la info de un dispositivo
     *
     * @return int Devuelve la cantidad de filas afectadas
    */
    public function update(int $id, array $data)
    {
        try {
            $_ = $this->db->update($this->table, [
                "lote" => trim($data["lote"]),
                "desc" => trim($data["desc"]),
                "marca" => trim($data["marca"]),
                "serie" => @$data["serie"],
                "invima" => trim($data["invima"]),
                "riesgo" => trim($data["riesgo"]),
                "cantidad" => $data["cantidad"],
                "carro_id" => trim((string) $data["carro_id"]),
                "vida_util" => trim($data["vida_util"]),
                "vencimiento" => $data["vencimiento"],
                "presentacion" => trim($data["presentacion"]),
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
            $_ = $this->db->delete($this->table, [
                "id" => $id
            ]);

            return $_->rowCount();
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Obtiene todos los dispositivos relacionados a un carro.
    */
    public function getFromCarro(int $carroId): array
    {
        try {
            return $this->db->select($this->table, "*", [
                "carro_id" => $carroId,
                "ORDER"    => "desc"
            ]);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function getInsertId(): int
    {
        return (int) $this->db->id();
    }
}
