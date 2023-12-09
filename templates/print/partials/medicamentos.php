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
      <?php if ($tipo == \App\Enums\CarroTipo::ESTANTE()): ?>
        <th>N. Comercial</th>
      <?php endif ?>
      <th>Invima</th>
      <th>Lote</th>
      <th>Fecha Vencimiento</th>
      <?php if ($tipo == \App\Enums\CarroTipo::CARRO()): ?>
        <th>Cant.</th>
      <?php endif ?>
    </tr>
  </thead>
  <tbody class="small">
    <?php foreach($med["after"] as $row): ?>
      <tr>
        <td><?= $row->p_activo_concentracion ?></td>
        <td><?= $row->forma_farma ?></td>
        <td><?= $row->medida ?></td>
        <td><?= $row->presentacion ?></td>
        <?php if ($tipo == \App\Enums\CarroTipo::ESTANTE()): ?>
          <td><?= $row->nombre_comercial ?></td>
        <?php endif ?>
        <td><?= $row->invima ?></td>
        <td><?= $row->lote ?></td>
        <td class="<?= $getDateColor($row->vencimiento, $compDate) ?>">
          <?= $printDate($row->vencimiento) ?>
        </td>
        <?php if ($tipo == \App\Enums\CarroTipo::CARRO()): ?>
          <td><?= $row->cantidad ?></td>
        <?php endif ?>
      </tr>
    <?php endforeach ?>
  </tbody>
</table>
