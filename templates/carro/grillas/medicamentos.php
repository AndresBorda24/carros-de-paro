<div
x-data="grillaMedicamentos"
x-bind="events"
class="small w-100 p-2 border rounded bg-body">
  <div class="d-flex flex-wrap gap-2 justify-content-between mb-2">
    <?php if ($this->can("medicamentos.create")): ?>
      <button
      x-cloak
      x-show="carroStatus"
      @click="$dispatch('create-medicamento', getCarroId())"
      class="btn btn-success btn-sm text-sm">
        <?= $this->fetch("./icons/plus.php") ?>
        Adjuntar Medicamento
      </button>
    <?php endif ?>

    <button
    x-data="printTable"
    @click="print('Medicamentos')"
    class="btn btn-dark btn-sm text-sm">
      <?= $this->fetch("./icons/print.php") ?>
      Imprimir Tabla
    </button>

    <div class="d-flex gap-1 flex-grow-1 justify-content-end">
      <?php if($this->can("grillas.ver-datos")): ?>
        <button
        @click="showData"
        class="btn btn-warning btn-sm text-sm">
          Mostrar datos
        </button>
      <?php endif ?>
    </div>
  </div>

  <table
  id="grilla-medicamentos"
  style="width:100%"
  data-can-edit="<?= (int) $this->can("medicamentos.edit") ?>"
  class="display compact responsive small nowrap">
    <thead>
      <tr>
        <th
        style="word-break: normal; white-space: pre-line"
        data-priority="1">Principio Activo / Concentraci&oacute;n</th>
        <th
        style="word-break: normal; white-space: pre-line"
        data-priority="4">Forma Farmaceutica</th>
        <th
        style="word-break: normal; white-space: pre-line"
        data-priority="5">Unidad Medida</th>
        <th
        style="word-break: normal; white-space: pre-line"
        data-priority="4">Presentaci&oacute;n Comercial</th>
        <th data-priority="3">Invima</th>
        <th data-priority="3">Lote</th>
        <th
        style="word-break: normal; white-space: pre-line"
        data-priority="2">Fecha Vencimiento</th>
        <th data-priority="1">Cant.</th>
        <th data-priority="0"></th>
      </tr>
    </thead>
  </table>
</div>
