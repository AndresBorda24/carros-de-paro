<div
x-data="grillaDispositivos"
x-bind="events"
class="small w-100 p-2 border rounded bg-body overflow-x-hidden">
  <div class="d-flex gap-2 mb-2 flex-wrap justify-content-between">
    <?php if ($this->can("dispositivos.create")): ?>
      <button
      x-cloak
      x-show="carroStatus"
      @click="$dispatch('create-dispositivo', getCarroId())"
      class="btn btn-success btn-sm text-sm">
        <?= $this->fetch("./icons/plus.php") ?>
        Adjuntar Dispositivo
      </button>
    <?php endif ?>

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
  id="grilla-dispositivos"
  style="width:100%"
  data-can-edit="<?= (int) $this->can("dispositivos.edit") ?>"
  class="display compact responsive small nowrap">
    <thead>
      <tr>
        <th data-priority="0">Descripci&oacute;n</th>
        <th data-priority="5">Marca</th>
        <th
        style="word-break: normal; white-space: pre-line"
        data-priority="4">Presentaci&oacute;n Comercial</th>
        <th data-priority="3">Invima</th>
        <th data-priority="3">Lote</th>
        <th
        style="word-break: normal; white-space: pre-line"
        data-priority="2">Fecha Vencimiento</th>
        <th data-priority="1">Cant.</th>
        <th
        style="word-break: normal; white-space: pre-line"
        data-priority="2">Vida &uacute;til</th>
        <th data-priority="3">Riesgo</th>
        <th data-priority="0"></th>
      </tr>
    </thead>
  </table>
</div>
