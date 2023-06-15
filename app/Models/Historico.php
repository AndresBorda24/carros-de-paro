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

            $this->db->select($this->table, ["id", "fecha", "hora", "model"], [
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
            $userTable = User::TABLE;

            $h = $this->db->get($this->table.' (H)', [
                "[>]$userTable (U)" => ["quien" => "usuario_id"]
            ], [
                "usuario" => Medoo::raw("CONCAT_WS(
                    ' ',
                    U.`usuario_apellido1`,
                    U.`usuario_apellido2`,
                    U.`usuario_nombre1`,
                    U.`usuario_nombre2`
                )"),
                "H.id",
                "H.model",
                "H.fecha",
                "H.hora",
                "H.carro_id",
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
            $sts = $this->db->pdo->prepare("
            SELECT id, fecha, hora
            FROM $this->table
            WHERE
                `model` = :model
                AND (
                    JSON_CONTAINS(
                        JSON_EXTRACT(
                            $this->table.`before`,
                            '$[*].$field'
                    ), :query, '$')
                    OR
                    JSON_CONTAINS(
                        JSON_EXTRACT(
                            $this->table.`after`,
                            '$[*].$field'
                    ), :query, '$')
                )
            ");

            if(! $sts->execute([
                ":model" => $model,
                ":query" => json_encode($query)
            ])) {
                return [];
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
