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
      <?php if ($tipo == \App\Enums\CarroTipo::ESTANTE()): ?>
        <th>Serie</th>
      <?php endif ?>
      <th>Invima</th>
      <th>Lote</th>
      <th>Fecha Vencimiento</th>
      <?php if ($tipo == \App\Enums\CarroTipo::CARRO()): ?>
        <th>Cant.</th>
      <?php endif ?>
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
        <?php if ($tipo == \App\Enums\CarroTipo::ESTANTE()): ?>
          <td><?= $row->serie ?></td>
        <?php endif ?>
        <td><?= $row->invima ?></td>
        <td><?= $row->lote ?></td>
        <td class="<?= $getDateColor($row->vencimiento, $compDate) ?>">
          <?= $printDate($row->vencimiento) ?>
        </td>
        <?php if ($tipo == \App\Enums\CarroTipo::CARRO()): ?>
          <td><?= $row->cantidad ?></td>
        <?php endif ?>
        <td><?= $row->vida_util ?></td>
        <td><?= $row->riesgo ?></td>
      </tr>
    <?php endforeach ?>
  </tbody>
</table>
