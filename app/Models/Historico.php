<?php
declare(strict_types=1);

namespace App\Models;

use Medoo\Medoo;

class Historico
{
    public CONST TABLE = "carro_historico";

    private Medoo $db;
    private array $required = [
        "after",
        "model",
        "before",
        "apertura_id",
    ];

    public function __construct(Medoo $db)
    {
        $this->db = $db;
    }

    /** Crea un historico */
    public function create(array $data): bool
    {
        try {
            $this->checkRequired($data);

            $this->db->insert(static::TABLE, [
                "model" => $data["model"],
                "apertura_id"  => $data["apertura_id"],
                "before[JSON]" => $data["before"],
                "after[JSON]"  => $data["after"]
            ]);

            return true;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Obtiene la fecha de todos los historicos de un carro y los agrupa
     * por modelo
    */
    public function getListFromCarro(int $carroId): array
    {
        try {
            $data = [
                "medicamentos" => [],
                "dispositivos" => []
            ];

            $this->db->select(static::TABLE, ["id", "fecha", "hora", "model"], [
                "carro_id" => $carroId,
                "ORDER" => [
                    "fecha" => "DESC",
                    "hora" => "DESC"
                ]
            ], function($reg) use(&$data) {
                $key = ($reg["model"] === \App\Services\HistoricoService::DISPOSITIVO)
                    ? "dispositivos"
                    : "medicamentos";

                array_push($data[$key], [
                    "id" => $reg["id"],
                    "fecha" => $reg["fecha"],
                    "hora"  => $reg["hora"]
                ]);
            });

            return $data;
        } catch(\Exception $e) {
            throw $e;
        }
    }

    /**
     * Obtiene un registro en base a su ID
    */
    public function find(int $id): ?array
    {
        try {
            $h = $this->db->get(static::TABLE.' (H)',[
                "H.id",
                "H.model",
                "H.before",
                "H.after",
            ],[
                "H.id" => $id
            ]);

            if ($h) {
                $h["after"]  = json_decode(
                    mb_convert_encoding($h["after"], 'UTF-8')
                );
                $h["before"] = json_decode($h["before"]);
            }

            return $h;
        } catch(\Exception $e) {
            throw $e;
        }
    }

    /**
     * Obtiene los Id de los registros que coincidan con $query. Busca las
     * coincidencias en los campos JSON `before` & `after`.
     *
     * @param string $model Dipositivo o Medicamento
     * @param string $field El campo de la tabla a buscar. Corresponden a los
     * campos de las tablas de cada modelo
     * @param string $query El valor a buscar.
    */
    public function search(string $model, string $field, string $query): array
    {
        try {
            $table = static::TABLE;
            $carroTable = Carro::TABLE;
            $aperturaTable = Apertura::TABLE;

            $sts = $this->db->pdo->prepare("
            SELECT $table.id, nombre, apertura_id, fecha, hora
            FROM $table
            LEFT JOIN $aperturaTable
            ON $aperturaTable.`id` = $table.`apertura_id`
            LEFT JOIN $carroTable
            ON $carroTable.`id` = $aperturaTable.`carro_id`
            WHERE
                `model` = :model
                AND
                JSON_CONTAINS(
                    JSON_EXTRACT(
                        $table.`after`,
                        '$[*].$field'
                ), :query, '$')
            ORDER BY nombre ASC, fecha ASC, hora ASC
            ");

            if(! $sts->execute([
                ":model" => $model,
                ":query" => json_encode($query)
            ])) {
                throw new \Exception(json_encode($sts->errorInfo()));
            }

            return $sts->fetchAll(\PDO::FETCH_ASSOC);
        } catch(\Exception $e) {
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
