<?php
declare(strict_types=1);

namespace App\Services;

use Medoo\Medoo;
use App\Models\Historico;
use App\Models\Medicamento;
use App\Models\Dispositivo;

/**
 * Esta clase se encarga de almacenar todos los historicos y, por ende, guarda
 * los dispositivos y medicamentos.
*/
class HistoricoService
{
    public CONST MEDICAMENTO = 1;
    public CONST DISPOSITIVO = 2;

    /**
     * Representa el tipo del modelo, lo recomendable es que sea una de las
     * constantes de la clase
    */
    private ?int $model = null;

    /**
     * Id del carro a actalizar
    */
    private ?int $carro_id = null;

    /**
     * Array de la informacion a actualizar. Es la informacion que DEBE quedar
     * registrada en el carro.
    */
    private ?array $updateData = null;

    /**
     * Representa los datos del carro antes de las modificaciones.
    */
    private ?array $before = null;

    /**
     * Representan los nuevos registros a insertar
    */
    private ?array $inserts = null;

    /**
     * Representan los nuevos registros a actualizar
    */
    private ?array $updates = null;

    /**
     * Representan los nuevos registros a eliminar
    */
    private ?array $deletes = null;

    /**
     * Modelos necesarios para las consultas en la base de datos
    */
    private Historico $h;
    private Medicamento $m;
    private Dispositivo $d;

    /**
     * Base de datos
    */
    private Medoo $db;

    public function __construct(
        Historico $h,
        Medicamento $m,
        Dispositivo $d,
        Medoo $db
    ) {
        $this->h  = $h;
        $this->m  = $m;
        $this->d  = $d;
        $this->db = $db;
    }

    /**
     * Guarda el modelo y genera un nuevo historico.
     *
     * @param array $data Array con 2 llaves. `[carro_id]` que es, bueno, eso
     * y `[data]` que es la info en si.
     * @param int $model Tipo de Modelo, Medicamento o Dispositivo. Es
     * recomendable que sea una de las constantes de esta clase.
    */
    public function store(array $data, int $model): bool
    {
        try {
            $error = null;

            $this->db->action(function() use($data, $model, &$error) {
                try {
                    // preparar la info que llega
                    $this->extractData($data, $model);

                    // Consultar los datos anteriores a la actualizacion
                    $this->setCurrentData();

                    // generar inserts, updates, o deletes
                    $this->setInserts();
                    $this->setUpdates();
                    $this->setDeletes();

                    // Relizar las consultas
                    $this->doInserts();
                    $this->doUpdates();
                    $this->doDeletes();

                    // Guardar el historico
                    $this->saveHistorico();
                    return true;
                } catch(\Exception $e) {
                    $error = $e;
                    return false;
                }
            });

            if ($error) {
                throw $error;
            }

            return true;
        } catch(\Exception $e) {
            throw $e;
        }
    }

    /**
     * Guarda un nuevo registro historico en la base de datos
    */
    private function saveHistorico()
    {
        try {
            $this->h->create([
                "carro_id" => $this->carro_id,
                "model"  => $this->model,
                "quien"  => "usr-id",
                "before[JSON]" => $this->before,
                "after[JSON]"  => $this->updateData
            ]);
        } catch(\Exception $e) {
            throw $e;
        }
    }

    /**
     * Setea `carro_id` y los datos a actualizar. Ademas, revisa que el tipo
     * del modelo corresponda con los soportados.
    */
    private function extractData(array $data, int $model)
    {
        // Verificamos Carro_id
        if (
            ! array_key_exists("carro_id", $data) ||  // Si no existe
            gettype($data["carro_id"]) !== 'integer' // O no es un entero
        ) {
            throw new \Exception("Falta Info: carro_id");
        }

        // Verificamos data
        if (
            ! array_key_exists("data", $data) ||  // Si no existe
            gettype($data["data"]) !== 'array' // O no es un array
        ) {
            throw new \Exception("Falta Info: data");
        }

        // Verificamos que el tipo del modelo sea adecuado
        if ( ! in_array($model, [
            static::DISPOSITIVO,
            static::MEDICAMENTO
        ])) {
            throw new \Exception("Modelo no soportado");
        }

        $this->model = $model;
        $this->carro_id = $data["carro_id"];
        $this->updateData = $data["data"];
    }

    /**
     * Busca los datos del carro actual (dependiendo si es para medicamentos
     * o dispositivos) y lo almacena en `$before`
    */
    public function setCurrentData()
    {
        if ($this->model === static::MEDICAMENTO) {
            $this->before = $this->m->getFromCarro( $this->carro_id );
            return;
        }

        if ($this->model === static::DISPOSITIVO) {
            $this->before = $this->d->getFromCarro( $this->carro_id );
            return;
        }
    }

    /**
     * Guarda los NUEVOS registros. Esto lo hace detectando los
     * registros que esten en `$updateData` pero no en `$before`
    */
    public function setInserts()
    {
        $INSERTS = array_diff(
            array_column($this->updateData, 'id'),
            array_column($this->before, 'id')
        );

        $this->inserts = array_filter(
            $this->updateData,
            function($_) use($INSERTS) {
                return in_array($_["id"], $INSERTS);
            }
        );
    }

    /**
     * Guarda los registros para actualizar. Esto lo hace detectando los
     * registros que estan en ambos arrays: `$before` y `$updateData`
    */
    private function setUpdates()
    {
        $UPDATES = array_intersect(
            array_column($this->before, 'id'),
            array_column($this->updateData, 'id')
        );

        $this->updates = array_filter(
            $this->updateData,
            function($_) use($UPDATES) {
                return in_array($_["id"], $UPDATES);
            }
        );
    }

    /**
     * Guarda los registros para eliminar. Esto lo hace detectando los
     * registros que estan en `$before` y NO en `$updateData`
    */
    private function setDeletes()
    {
        $DELETES = array_diff(
            array_column($this->before, 'id'),
            array_column($this->updateData, 'id')
        );

        $this->deletes = array_filter(
            $this->before,
            function($_) use($DELETES) {
                return in_array($_["id"], $DELETES);
            }
        );
    }

    /**
     * Reliza la insercion de los nuevos registros a la tabla que corresponda
    */
    private function doInserts()
    {
        try {
            $model = $this->getModel();

            foreach($this->inserts as $insertData) {
                $this->$model->create($insertData);
            }
        } catch(\Exception $e) {
            throw $e;
        }
    }

    /**
     * Reliza las actualizaciones de los registros a la tabla que corresponda
    */
    private function doUpdates()
    {
        try {
            $model = $this->getModel();

            foreach($this->updates as $updateData) {
                $this->$model->update($updateData["id"], $updateData);
            }
        } catch(\Exception $e) {
            throw $e;
        }
    }

    /**
     * Elimina los registros a la tabla que corresponda
    */
    private function doDeletes()
    {
        try {
            $model = $this->getModel();

            foreach($this->deletes as $deleteData) {
                $this->$model->delete($deleteData["id"]);
            }
        } catch(\Exception $e) {
            throw $e;
        }
    }

    /**
     * Obtiene el nombre de la propiedad que corresponde al modelo. Esto es
     * para poder usar los inserts, updates y deletes de forma dinamca.
    */
    private function getModel(): string
    {
        if ($this->model === static::MEDICAMENTO) {
            return "m";
        }

        if ($this->model === static::DISPOSITIVO) {
            return "d";
        }
    }

}
