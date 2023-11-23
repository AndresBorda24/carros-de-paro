<?php
declare(strict_types=1);

namespace App\Models;

use App\Enums\CarroTipo;
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
    public function getAll(CarroTipo $tipo): ?array
    {
        try {
            return $this->db->select(static::TABLE, "*", [
                "tipo" => $tipo->getValue()
            ]);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Retorna un array con los medicamentos o dispositivos que esten proximos a vencer
    */
    public function getProximosAVencer(): array
    {
        try {
            $data = [
                "medicamentos" => [],
                "dispositivos" => []
            ];

            // Cantidad de plazo en meses para la busqueda
            $meses = 2;

            $consulta = $this->db->pdo->query("
                SELECT
                    D.desc AS nombre, D.vencimiento,
                    C.nombre as carro, C.ubicacion, 'dispositivos' AS tipo
                    FROM carro_reg_dispositivos AS D
                    JOIN carros as C ON C.id = D.carro_id
                    WHERE vencimiento BETWEEN NOW() AND DATE_ADD( NOW(), INTERVAL $meses MONTH)
                UNION
                SELECT
                    M.p_activo_concentracion AS nombre, M.vencimiento,
                    C.nombre as carro, C.ubicacion, 'medicamentos' AS tipo
                    FROM carro_reg_medicamentos as M
                    JOIN carros as C ON C.id = M.carro_id
                    WHERE vencimiento BETWEEN NOW() AND DATE_ADD( NOW(), INTERVAL $meses MONTH)
                ORDER BY vencimiento;
            ");

            if (!$consulta || $consulta->rowCount() === 0) return [];

            while ($d =  $consulta->fetch(\PDO::FETCH_ASSOC)) {
                array_push( $data[$d["tipo"]], $d );
            }

            return $data;
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
