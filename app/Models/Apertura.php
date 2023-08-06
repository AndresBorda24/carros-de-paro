<?php
declare(strict_types=1);

namespace App\Models;

use Medoo\Medoo;

class Apertura
{
    CONST TABLE = "carro_aperturas";

    private Medoo $db;

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
     * Actualiza una Apertura dependiendo de su id
    */
    public function update(int $id, array $data): int
    {
        try {
            $_ = $this->db->update(static::TABLE, [
                "mensaje" => $data["mensaje"]
            ], ["id" => $id]);

            return $_->rowCount();
        } catch(\Exception $e) {
            throw $e;
        }
    }

    /**
     * Crea los registros en el historico a partir de una apertura. Si no se
     * puede generar el historico ELIMINA la apertura.
    */
    public function createHistorico(int $id, array $data): bool
    {
        try {
            $e = null;
            $this->db->action(function() use($id, $data, &$e) {
                try {
                    $h = new Historico($this->db);
                    $h->create([
                        "model" => Medicamento::MODEL,
                        "before" => $data["medicamentos"],
                        "after"  => $data["medicamentos"],
                        "apertura_id" => $id
                    ]);
                    $h->create([
                        "model" => Dispositivo::MODEL,
                        "before" => $data["dispositivos"],
                        "after"  => $data["dispositivos"],
                        "apertura_id" => $id
                    ]);
                    return true;
                } catch(\Exception $ex) {
                    $e = $ex;
                    return false;
                }
            });

            if ($e) throw $e;
            return true;
        } catch(\Exception $e) {
            $this->delete($id);
            throw new \Exception("No se ha podido guardar la apertura.", 24002, $e);
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
                "C.nombre (carro_nombre)", "C.ubicacion (carro_ubicacion)",
                "H.after", "H.before", "H.model",
                "A.id", "A.fecha", "A.hora", "A.motivo", "A.mensaje",
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
                $_["mensaje"] = $reg["mensaje"];
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
     * Elimina una apertura. Unicamente se emplea si se genera un error
     * al crear el historico en el AperturasController.
    */
    public function delete(int $id): int
    {
        try {
            $_ = $this->db->delete(self::TABLE, [
                "id" => $id
            ]);

            return $_->rowCount();
        } catch(\Exception $e) {
            throw $e;
        }
    }
}
