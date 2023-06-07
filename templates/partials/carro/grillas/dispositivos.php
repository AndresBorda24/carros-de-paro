<div x-data="grillaDispositivos" x-bind="events" class="small w-100">
  <button
  @click="$dispatch('create-dispositivo', getCarroId())"
  class="btn btn-success btn-sm text-sm mb-3">
    <?= $this->fetch("./icons/plus.php") ?>
    Adjuntar Dispositivo
  </button>

  <table
  id="grilla-dispositivos"
  style="width:100%"
  class="display compact responsive small">
    <thead>
      <tr>
        <th data-priority="1">Descripci&oacute;n</th>
        <th data-priority="3">Marca</th>
        <th data-priority="3">Presentaci&oacute;n Comercial</th>
        <th data-priority="4">Invima</th>
        <th data-priority="4">Lote</th>
        <th data-priority="2">Fecha Vencimiento</th>
        <th data-priority="1">Cantidad</th>
        <th data-priority="2">Vida &uacute;til</th>
        <th data-priority="3">Riesgo</th>
        <th data-priority="1"></th>
      </tr>
    </thead>
  </table>
</div>
