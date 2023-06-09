<?php
declare(strict_types=1);

namespace App\Models;

use Medoo\Medoo;

class Registro
{
    public CONST INSERT = "INSERT";
    public CONST DELETE = "DELETE";
    public CONST UPDATE = "UPDATE";

    private Medoo $db;
    private string $table;

    public function __construct(Medoo $db)
    {
        $this->db = $db;
        $this->table = "carro_registro";
    }

    public function create(array $data)
    {
        try {
            $_ = $this->db->insert($this->table, [
                "carro_id"     => $data["carro_id"],
                "carro_nombre" => $data["carro_nombre"],
                "action"       => $data["action"],
                "model"        => $data["model"],
                "model_nombre" => $data["model_nombre"],
                "usuario_id"   => $data["usuario_id"],
                "detalle"      => $data["detalle"],
                "fecha"        => Medoo::raw("CURDATE()"),
                "hora"         => Medoo::raw("CURTIME()")
            ]);

            return $_;
        } catch(\Exception $e) {
            throw $e;
        }
    }

    /**
     * Devuelve los registros de cierto carro que esten entre las fechas
     * `$start` y `$end` y agrupados por fecha.
    */
    public function getReg(int $carroId, string $start, string $end): array
    {
        try {
            $data = [];

            $this->db->select($this->table, [
                "id",
                "hora",
                "fecha",
                "model",
                "action",
                "detalle",
                "usuario_id",
                "model_nombre"
            ], [
                "AND" => [
                    "carro_id"  => $carroId,
                    "fecha[<>]" => [$start, $end]
                ]
            ], function($r) use(&$data) {
                if (! array_key_exists($r["fecha"], $data)) {
                    $data[ $r["fecha"] ] = [];
                }

                array_push($data[ $r["fecha"] ], [
                    "id" => $r["id"],
                    "hora" => $r["hora"],
                    "model" => $r["model"],
                    "action" => $r["action"],
                    "detalle" => $r["detalle"],
                    "usuario_id" => $r["usuario_id"],
                    "model_nombre" => $r["model_nombre"]
                ]);
            });

            return $data;
        } catch(\Exception $e) {
            throw $e;
        }
    }

    /**
     * Obtiene el ultimo error de mysql
    */
    public function getError()
    {
        return $this->db->error;
    }
}
