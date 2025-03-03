<thead>
  <tr>
    <th class=" d-flex align-items-center justify-content-between">
      <img
      class="w-41"
      src="<?= $this->asset("img/logo.png") ?>"
      alt="logo-asotrauma">
      <span class="badge text-bg-light rounded-1 fw-medium">
        <span>
          <?php if($tipo == \App\Enums\CarroTipo::CARRO()): ?>
            Carro de paro - <?= ($carro_nombre ?? '') ?>
          <?php elseif($tipo == \App\Enums\CarroTipo::ESTANTE()): ?>
            Revisi&oacute;n de Estante - <?= ($carro_nombre ?? '') ?>
          <?php elseif($tipo == \App\Enums\CarroTipo::KIT()): ?>
            Revisi&oacute;n de Kit - <?= ($carro_nombre ?? '') ?>
          <?php endif ?>
        </span>
      </span>
    </th>
  </tr>
  <tr>
    <th class="small text-muted">
      <span class="small">
        Revisi&oacute;n <?= $usuario ?> | <?= $fecha ?>
      </span>
    </th>
  </tr>
</thead>
