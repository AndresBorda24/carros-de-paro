<div x-data="grillaMedicamentos" class="small w-100">
  <button
  @click="$dispatch('create-medicamento', getCarroId())"
  class="btn btn-success btn-sm text-sm mb-3">
    <?= $this->fetch("./icons/plus.php") ?>
    Adjuntar Medicamento
  </button>

  <table
  id="grilla-medicamentos"
  style="width:100%"
  class="display compact responsive small">
    <thead>
      <tr>
        <th></th>
        <th data-priority="1">Principio Activo</th>
        <th data-priority="2">Concentraci&oacute;n</th>
        <th data-priority="2">Forma Farmaceutica</th>
        <th data-priority="2">Medida</th>
        <th data-priority="2">Presentaci&oacute;n</th>
        <th data-priority="3">Invima</th>
        <th data-priority="3">Lote</th>
        <th data-priority="2">Vencimiento</th>
        <th data-priority="1">Cantidad</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td></td>
        <td>1735hsgavdh</td>
        <td>1735hsgavdh</td>
        <td>1735hsgavdh</td>
        <td>1735hsgavdh</td>
        <td>1735hsgavdh</td>
        <td>1735hsgavdh</td>
        <td>1735hsgavdh</td>
        <td>1735hsgavdh</td>
        <td>1735hsgavdh</td>
      </tr>
    </tbody>
  </table>
</div>
