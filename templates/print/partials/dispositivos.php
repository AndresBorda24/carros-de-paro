<table class="table table-sm mb-5 border small">
  <thead>
    <tr>
      <th colspan="9">
        <span class="fw-bodl">Dispositivos</span>
      </th>
    </tr>
    <tr>
      <th>Descripci&oacute;n</th>
      <th>Marca</th>
      <th>Presentaci&oacute;n</th>
      <th>Invima</th>
      <th>Lote</th>
      <th>Fecha Vencimiento</th>
      <th>Cant.</th>
      <th>Vida &uacute;til</th>
      <th>Riesgo</th>
    </tr>
  </thead>
  <tbody class="small">
    <?php foreach($dis["after"] as $row): ?>
      <tr>
        <td><?= $row->desc ?></td>
        <td><?= $row->marca ?></td>
        <td><?= $row->presentacion ?></td>
        <td><?= $row->invima ?></td>
        <td><?= $row->lote ?></td>
        <td class="<?= $dateColor($row->vencimiento) ?>">
          <?= $printDate($row->vencimiento) ?>
        </td>
        <td><?= $row->cantidad ?></td>
        <td><?= $row->vida_util ?></td>
        <td><?= $row->riesgo ?></td>
      </tr>
    <?php endforeach ?>
  </tbody>
</table>
