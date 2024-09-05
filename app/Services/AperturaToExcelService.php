<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\CarroTipo;
use App\Enums\TipoItem;
use App\Models\Apertura;
use Shuchkin\SimpleXLSXGen;

class AperturaToExcelService
{
    private Apertura $apertura;
    private SimpleXLSXGen $excel;
    private array $aperturaData = [];
    private ?array $listadoAperturas = null;

    /** Almacena la informacion de las Hojas de calculo */
    private array $sheets = [];

    public function __construct(Apertura $apertura)
    {
        $this->apertura = $apertura;
        $this->excel = new SimpleXLSXGen();
    }

    /**
     * Carga todas las aperturas de un tipo de carro especifico.
    */
    public function loadAperturas(CarroTipo $tipo): void
    {
        $this->listadoAperturas = $this->apertura->findAll($tipo);
    }

    /**
     * Genera una hoja descriminando únicamente por su tipo, es decir, crea dos
     * hojas: una para los medicamentos de todos los carros y otra para
     * todos los dispositivos.
    */
    public function generateExcel(): void
    {
        foreach ($this->sheets as $name => $sheet) {
            $tipo = TipoItem::from($name);
            $headers = $this->getHeaders($tipo);
            $headers[] = 'carro';
            $newData = array_reduce($sheet, function($c, $item) {
                array_push($c, ...$item);
                return $c;
            }, []);
            array_unshift($newData, $headers);
            $this->excel->addSheet($newData, $name);
        }
        $this->excel->saveAs(sprintf('excel-carros-%s.xlsx', time()));
    }

    /**
     * Genera una hoja por tipo de item discriminado por carro. Es decir,
     * para un carro  crea 2 hojas: una para medicamentos y otra para los
     * dispositivos.
     */
    public function generateExcelIndividual(): void
    {
        foreach ($this->sheets as $name => $sheet) {
            $tipo = TipoItem::from($name);
            $headers = $this->getHeaders($tipo);
            $headers[] = 'carro';

            array_walk($sheet, function($sh, $carroNombre) use($headers, $name) {
                $data = [$headers, ...$sh];
                $this->excel->addSheet($data, "$name-$carroNombre");
            });
        }
        $this->excel->saveAs(sprintf('excel-carros-indvidual-%s.xlsx', time()));
    }

    /** Crea una nueva Hoja dependiendo del tipo de item seleccionado. */
    public function setSheet(TipoItem $tipo)
    {
        $this->checkListadoAperturas();
        $sheet = [];
        foreach ($this->listadoAperturas as $apertura) {
            $this->aperturaData = $apertura;
            $items = $this->aperturaToArray($tipo);
            $sheet[$this->aperturaData['carro_nombre']] = $items;
        }
        $this->sheets[$tipo->getValue()] = $sheet;
    }


    /** Helper para la funcion `setSheet` */
    public function setDispositivosSheet(): void
    {
        $this->setSheet(TipoItem::DISPOSITIVO());
    }

    /** Helper para la funcion `setSheet` */
    public function setMedicamentosSheet(): void
    {
        $this->setSheet(TipoItem::MEDICAMENTO());
    }

    /**
     * Retorna todos los medicamentos o dispositivos de una apertura.
    */
    public function aperturaToArray(TipoItem $tipo): array
    {
        $items   = $this->getItems($tipo);
        $headers = $this->getHeaders($tipo);

        return array_map(function($item) use($headers) {
            $newItem = [];
            foreach ($headers as $header) {
                $newItem[] = $item[$header];
            }
            $newItem[] = $this->aperturaData['carro_nombre'];
            return $newItem;
        }, $items);
    }

    /**
     * Obtiene el listado de medicamentos o dispositivos de una apertura.
    */
    private function getItems(TipoItem $tipo): array
    {
        $key = $tipo->getValue();

        return (array_key_exists($key, $this->aperturaData))
            ? array_map(fn($x) => (array) $x, $this->aperturaData[$key]['after'])
            : [];
    }

    /**
     * Verifica que se hayan cargado las aperturas para la generacion del Excel
    */
    private function checkListadoAperturas(): void
    {
        if (gettype($this->listadoAperturas) === 'NULL') {
            throw new \RuntimeException("Listado de Aperturas no definido. Recuerda usar el método: <loadAperturas>");
        }
    }

    /**
     * Retorna el listado de los campos que deben aparecer en el excel para los
     * medicamentos o los dispositivos.
    */
    private function getHeaders(TipoItem $tipo): array
    {
        return $tipo->equals(TipoItem::MEDICAMENTO())
            ? [ "lote", "medida", "invima", "cantidad", "forma_farma", "vencimiento", "presentacion", "nombre_comercial", "p_activo_concentracion"]
            : [ "lote", "desc", "marca", "serie", "invima", "riesgo", "cantidad", "vida_util", "vencimiento", "presentacion" ]
        ;
    }
}
