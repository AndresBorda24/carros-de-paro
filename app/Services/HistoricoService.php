<?php
declare(strict_types=1);

namespace App\Services;

use App\Auth;
use Medoo\Medoo;
use App\Models\Historico;
use App\Contracts\ModelInterface;
use App\Contracts\UserInterface;

/**
 * Esta clase se encarga de almacenar todos los historicos y, por ende, guarda
 * los dispositivos y medicamentos.
*/
class HistoricoService
{
    public CONST MEDICAMENTO = "Medicamento";
    public CONST DISPOSITIVO = "Dispositivo";

    /**
     * Representa el tipo del modelo, lo recomendable es que sea una de las
     * constantes de la clase
    */
    private ?ModelInterface $model = null;

    /**
     * Id del carro a actalizar
    */
    private ?int $aperturaId = null;

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

    /**
     * Base de datos
    */
    private Medoo $db;

    public function __construct(
        Historico $h,
        Medoo $db
    ) {
        $this->h  = $h;
        $this->db = $db;
    }

    /**
     * Guarda el modelo y genera un nuevo historico.
     *
     * @param array $data Array con 2 llaves. `[aperturaId]` que es, bueno, eso
     * y `[data]` que es la info en si.
     * @param ModelInterface $model Tipo de Modelo, Medicamento o Dispositivo. Es
     * recomendable que sea una de las constantes de esta clase.
    */
    public function store(
        array $data,
        ModelInterface $model,
        int $aperturaId,
        int $carroId
    ): bool {
        try {
            // preparar la info que llega
            $this->extractData($data, $model, $aperturaId);

            // Consultar los datos anteriores a la actualizacion
            $this->setCurrentData($carroId);

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
            throw $e;
        }
    }

    /**
     * Guarda un nuevo registro historico en la base de datos
    */
    private function saveHistorico()
    {
        try {
            preg_match('/(\w+)$/', get_class($this->model), $t);

            $this->h->create([
                "apertura_id" => $this->aperturaId,
                "model"  => $t[0],
                "before" => $this->before,
                "after"  => $this->updateData
            ]);
        } catch(\Exception $e) {
            throw $e;
        }
    }

    /**
     * Setea `aperturaId` y los datos a actualizar. Ademas, revisa que el tipo
     * del modelo corresponda con los soportados.
    */
    private function extractData(array $data, ModelInterface $model, int $aperturaId)
    {
        // Verificamos aperturaId
        if ($aperturaId <= 0) {
            throw new \Exception("Error: aperturaId");
        }

        // Verificamos data
        if ( gettype($data) !== 'array' ) {
            throw new \Exception("Falta Info: data");
        }

        $this->model = $model;
        $this->aperturaId = $aperturaId;
        $this->updateData = $data;
    }

    /**
     * Busca los datos del carro actual (dependiendo si es para medicamentos
     * o dispositivos) y lo almacena en `$before`
    */
    public function setCurrentData(int $carroId)
    {
        $this->before = $this->model->getFromCarro( $carroId );
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
            foreach($this->inserts as $insertData) {
                $this->model->create($insertData);
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
            foreach($this->updates as $updateData) {
                $this->model->update((int) $updateData["id"], $updateData);
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
            foreach($this->deletes as $deleteData) {
                $this->model->delete((int) $deleteData["id"]);
            }
        } catch(\Exception $e) {
            throw $e;
        }
    }
}
