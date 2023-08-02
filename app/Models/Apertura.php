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
     * Obtiene informacion basica de todas las aperturas relacionadas a un
     * carro.
    */
    public function getFromCarro(int $carroId): array
    {
        try {
            return $this->db->select(static::TABLE, [
                "id", "fecha", "hora"
            ], [
                "carro_id" => $carroId,
                "ORDER" => [
                    "fecha" => "DESC",
                    "hora"  => "DESC"
                ],
            ]);
        } catch(\Exception $e) {
            throw $e;
        }
    }

    /**
     * Busca la informacion de una apertura.
    */
    public function find(int $id)
    {
        try {
            $_ = [];

            $this->db->select(static::TABLE." (A)", [
                "[>]".Historico::TABLE." (H)" => ["id" => "apertura_id"],
                "[>]".User::TABLE." (U)" => ["quien" => "usuario_id"],
                "[>]".Carro::TABLE." (C)" => ["carro_id" => "id"]
            ], [
                "C.nombre (carro_nombre)",
                "C.ubicacion (carro_ubicacion)",
                "H.after", "H.before", "H.model",
                "A.id", "A.fecha", "A.hora", "A.motivo",
                "usuario" => Medoo::raw("CONCAT_WS(
                    ' ',
                    U.`usuario_apellido1`,
                    U.`usuario_apellido2`,
                    U.`usuario_nombre1`,
                    U.`usuario_nombre2`
                )")
            ], [
                "A.id" => $id
            ], function($reg) use(&$_){
                $_["id"]      = $reg["id"];
                $_["hora"]    = $reg["hora"];
                $_["fecha"]   = $reg["fecha"];
                $_["motivo"]  = $reg["motivo"];
                $_["usuario"] = $reg["usuario"];
                $_["carro_nombre"] = $reg["carro_nombre"];
                $_["carro_ubicacion"] = $reg["carro_ubicacion"];

                $_[$reg["model"]] = [
                    "before" => json_decode(
                        mb_convert_encoding($reg["before"], "UTF8")
                    ),
                    "after" => json_decode(
                        mb_convert_encoding($reg["after"], "UTF8")
                    )
                ];
            });

            return $_;
        } catch(\Exception $e) {
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
