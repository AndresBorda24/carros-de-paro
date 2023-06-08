<?php
declare(strict_types=1);

namespace App\Services;

use App\Config;
use App\Models\Registro;

class RegistroService
{
    private int $quien;
    private Registro $reg;
    private Config $config;

    public function __construct(Registro $reg, Config $config)
    {
        $this->reg = $reg;
        $this->quien = 126534;
        $this->config = $config;
    }

    /**
     * Guarda en el registro la accion hecha en un medicamento.
     *
     * @param string $action La accion que se realiza, es recomendable que se
     * utilize una de las constantes de `\App\Models\Registro`
    */
    public function medicamento(array $data, string $action, ?array $dtl = null): void
    {
        try {
            $_ = $this->reg->create([
                "carro_id"     => $data["carro_id"],
                "carro_nombre" => $data["carro_nombre"],
                "action"       => $action,
                "model"        => "Medicamento",
                "model_nombre" => $data["med_nombre"],
                "usuario_id"   => $this->quien,
                "detalle"      => $this->getDetalles($dtl)
            ]);

            if (! $_) throw new \Exception(
                "No se ha realizado la insercion: " . $this->reg->getError()
            );
        } catch(\Exception $e) {
            $this->storeInLog($e);
        }
    }

    /**
     * Guarda en el registro la accion hecha en un dispositivo.
     *
     * @param string $action La accion que se realiza, es recomendable que se
     * utilize una de las constantes de `\App\Models\Registro`
    */
    public function dispositivo(array $data, string $action, ?array $dtl = null): void
    {
        try {
            $_ = $this->reg->create([
                "carro_id"     => $data["carro_id"],
                "carro_nombre" => $data["carro_nombre"],
                "action"       => $action,
                "model"        => "Dispositivo",
                "model_nombre" => $data["dis_nombre"],
                "usuario_id"   => $this->quien,
                "detalle"     => $this->getDetalles($dtl)
            ]);

            if (! $_) throw new \Exception(
                "No se ha realizado la insercion: " . $this->reg->getError()
            );
        } catch(\Exception $e) {
            $this->storeInLog($e);
        }
    }

    /**
     * Guarda en el registro la accion hecha en un carro.
     *
     * @param string $action La accion que se realiza, es recomendable que se
     * utilize una de las constantes de `\App\Models\Registro`
    */
    public function carro(array $data, string $action, ?array $dtl = null): void
    {
        try {
            $_ = $this->reg->create([
                "carro_id"     => $data["carro_id"],
                "carro_nombre" => $data["carro_nombre"],
                "action"       => $action,
                "model"        => "Carro",
                "model_nombre" => $data["nombre"],
                "usuario_id"   => $this->quien,
                "detalle"     => $this->getDetalles($dtl)
            ]);

            if (! $_) throw new \Exception(
                "No se ha realizado la insercion: " . $this->reg->getError()
            );
        } catch(\Exception $e) {
            $this->storeInLog($e);
        }
    }

    /**
     * Registra el error en un documento de texto.
    */
    private function storeInLog(\Exception $e)
    {
        $log = fopen($this->config->get('errores_reg'), "a");
        if (! $log) return;

        $message = "Error ----------------- Linea: " . $e->getLine() . "\n";
        $message .= $e->getMessage() . "\n";
        $message .= "En archivo: " . $e->getFile() . "\n\n";

        fwrite($log, $message);
        fclose($log);
    }

    /**
     * Organiza los "detalles" del registro. Estos son los nuevos datos del
     * "Modelo" se usa cuando es una insercion o actualizacion.
    */
    public function getDetalles(?array $dtl): ?string
    {
        if ($dtl !== null) {
            $_ = "";

            foreach ($dtl as $key => $value) {
                if (in_array($key, ["id", "carro_id"])) {
                    continue;
                }

                $_ .= "-> $value\n";
            }

            $dtl = $_;
        }

        return $dtl;
    }
}

