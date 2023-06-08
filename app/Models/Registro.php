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

    public function getError()
    {
        return $this->db->error;
    }
}
