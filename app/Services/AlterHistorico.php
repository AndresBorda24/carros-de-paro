<?php
declare(strict_types=1);

namespace App\Services;

use App\Contracts\ModelInterface;
use App\Models\Historico;

/**
 * Esta clase se va a encargar de modificar el after del historico de una
 * apertura en cualquier accion CUD (Create update o delete) en medicamentos
 * o dispositivos.
*/
class AlterHistorico
{
    private Historico $historico;

    private int $aperturaId = 0;
    private ?ModelInterface $model = null;

    public function __construct(Historico $historico)
    {
        $this->historico = $historico;
    }

    /**
     * Setea informacion necesaria.
    */
    public function setData(ModelInterface $model, int $aperturaId)
    {
        $this->model = $model;
        $this->aperturaId = $aperturaId;
    }

    /**
     * Registra la insercion de un medicamento o dispositivo
    */
    public function insert(array $data)
    {
        try {
            $after = $this->findHistorico();
            array_push($after["after"], $data);

            $this->historico->setAfter($after["id"], $after["after"]);
        } catch(\Exception $e) {
            throw $e;
        }
    }

    /**
     * Registra la actualizacion de un medicamento o dispositivo
    */
    public function update(array $data)
    {
        try {
            $after = $this->findHistorico();
            $index = $this->findIndex($data["id"], $after["after"]);
            $after["after"][$index] = $data;

            $this->historico->setAfter($after["id"], $after["after"]);
        } catch(\Exception $e) {
            throw $e;
        }
    }

    /**
     * Registra el delete de un medicamento o dispositivo
    */
    public function delete(int $id)
    {
        try {
            $after = $this->findHistorico();
            $index = $this->findIndex($id, $after["after"]);
            array_splice($after["after"], $index, 1);

            $this->historico->setAfter($after["id"], $after["after"]);
        } catch(\Exception $e) {
            throw $e;
        }
    }

    /**
     * Encontramos el indice de un modelo en el array `after`.
    */
    private function findIndex(int $id, array $after): int
    {
        $i = null;
        foreach ($after as $key => $_) {
            if ($_['id'] === $id) {
                $i = $key;
                break;
            }
        }

        if ($i === null) throw new \Exception("No se encontro en item");

        return $i;
     }

    /**
     * Recupera el `after` del historico
    */
    private function findHistorico(): array
    {
        try {
            if (! $this->model || $this->aperturaId === 0) {
                throw new \Exception("Data no setted...");
            }

            return $this->historico->fetchAfter(
                $this->model->getModel(),
                $this->aperturaId
            );
        } catch(\Exception $e) {
            throw $e;
        }
    }
}
