<div
x-data="grillaDispositivos"
x-bind="events"
class="small w-100 p-2 border rounded bg-body">
  <div class="d-flex mb-2 flex-wrap justify-content-between">
    <button
    @click="$dispatch('create-dispositivo', getCarroId())"
    class="btn btn-success btn-sm text-sm">
      <?= $this->fetch("./icons/plus.php") ?>
      Adjuntar Dispositivo
    </button>

    <button
    x-data="printTable"
    @click="print('Dispositivos')"
    class="btn btn-dark btn-sm text-sm">
      <?= $this->fetch("./icons/print.php") ?>
      Imprimir Tabla
    </button>

    <div class="d-flex gap-1">
      <button
      @click="revertChanges"
      x-show="hasChanged"
      style="border-style: dotted;"
      class="btn btn-outline-info btn-sm text-sm fw-bold">
        <?= $this->fetch("./icons/return.php") ?>
        Revertir Cambios
      </button>

      <button
      x-data="guardarCarroDispositivos"
      @click="save"
      x-show="hasChanged"
      class="btn btn-success btn-sm text-sm">
        <?= $this->fetch("./icons/check.php") ?>
        Guardar Cambios
      </button>

      <button
      @click="showData"
      class="btn btn-warning btn-sm text-sm">
        Mostrar datos
      </button>
    </div>
  </div>

  <table
  id="grilla-dispositivos"
  style="width:100%"
  class="display compact responsive small">
    <thead>
      <tr>
        <th data-priority="1">Descripci&oacute;n</th>
        <th data-priority="3">Marca</th>
        <th
        style="word-break: normal; white-space: pre-line"
        data-priority="3">Presentaci&oacute;n Comercial</th>
        <th data-priority="4">Invima</th>
        <th data-priority="4">Lote</th>
        <th
        style="word-break: normal; white-space: pre-line"
        data-priority="2">Fecha Vencimiento</th>
        <th data-priority="1">Cant.</th>
        <th
        style="word-break: normal; white-space: pre-line"
        data-priority="2">Vida &uacute;til</th>
        <th data-priority="3">Riesgo</th>
        <th data-priority="1"></th>
      </tr>
    </thead>
  </table>
</div>
