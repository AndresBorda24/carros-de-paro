<table class="table table-sm mb-5 border small">
  <thead>
    <tr>
      <th colspan="8">
        <span class="fw-bodl">Medicamentos</span>
      </th>
    </tr>
    <tr>
      <th>Principio Activo / Concentraci&oacute;n</th>
      <th>Forma Farmac&eacute;utica</th>
      <th>U / medida</th>
      <th>Presentaci&oacute;n</th>
      <th>Invima</th>
      <th>Lote</th>
      <th>Fecha Vencimiento</th>
      <th>Cantidad</th>
    </tr>
  </thead>
  <tbody class="small">
    <?php foreach($med["after"] as $row): ?>
      <tr>
        <td><?= $row->p_activo_concentracion ?></td>
        <td><?= $row->forma_farma ?></td>
        <td><?= $row->medida ?></td>
        <td><?= $row->presentacion ?></td>
        <td><?= $row->invima ?></td>
        <td><?= $row->lote ?></td>
        <td class="<?= $getDateColor($row->vencimiento, $compDate) ?>">
          <?= $printDate($row->vencimiento) ?>
        </td>
        <td><?= $row->cantidad ?></td>
      </tr>
    <?php endforeach ?>
  </tbody>
</table>
