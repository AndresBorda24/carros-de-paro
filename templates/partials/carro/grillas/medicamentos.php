<div x-data="grillaMedicamentos" x-bind="events" class="small w-100">
  <button
  @click="$dispatch('create-medicamento', getCarroId())"
  class="btn btn-success btn-sm text-sm">
    <?= $this->fetch("./icons/plus.php") ?>
    Adjuntar Medicamento
  </button>

  <table
  id="grilla-medicamentos"
  style="width:100%"
  class="display compact responsive small">
    <thead>
      <tr>
        <th data-priority="1">Principio Activo / Concentraci&oacute;n</th>
        <th data-priority="3">Forma Farmaceutica</th>
        <th data-priority="3">Unidad Medida</th>
        <th data-priority="3">Presentaci&oacute;n Comercial</th>
        <th data-priority="4">Invima</th>
        <th data-priority="4">Lote</th>
        <th data-priority="2">Fecha Vencimiento</th>
        <th data-priority="1">Cantidad</th>
        <th data-priority="1"></th>
      </tr>
    </thead>
  </table>
</div>
