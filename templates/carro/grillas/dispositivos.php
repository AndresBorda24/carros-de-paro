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
                class="btn btn-success btn-sm text-sm flex items-center gap-2"
        >
            <?= $this->fetch("./icons/plus.php") ?>
            <span>Adjuntar Dispositivo</span>
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
  class="display compact small nowrap w-100">
    <thead>
      <tr>
        <th class="dis_desc" data-priority="0">Descripci&oacute;n</th>
        <th class="dis_marca" data-priority="5">Marca</th>
        <th class="dis_presentacion"
        style="word-break: normal; white-space: pre-line"
        data-priority="4">Presentaci&oacute;n Comercial</th>
        <?php if($this->isRoute("carros.estantes")): ?>
          <th class="dis_serie" data-priority="3">Serie</th>
        <?php endif ?>
        <th class="dis_invima" data-priority="3">Invima</th>
        <th class="dis_lote" data-priority="3">Lote</th>
        <th class="dis_vida_util"
        style="word-break: normal; white-space: pre-line"
        data-priority="2">Vida &uacute;til</th>
        <th class="dis_riesgo" data-priority="3">Riesgo</th>
        <th class="dis_vencimiento"
        style="word-break: normal; white-space: pre-line"
        data-priority="2">Fecha Vencimiento</th>
        <?php if($this->isRoute("carros.index")): ?>
          <th class="dis_cantidad" data-priority="1">Cant.</th>
        <?php endif ?>
        <th data-priority="0"></th>
      </tr>
    </thead>
  </table>
</div>
