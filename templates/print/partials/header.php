<thead>
  <tr>
    <th class=" d-flex align-items-center justify-content-between">
      <img
      height="35"
      src="<?= $this->asset("img/logo.png") ?>"
      alt="logo-asotrauma">
      <span class="badge text-bg-light rounded-1 fw-medium">
        <span> <?= $tipo == \App\Enums\CarroTipo::CARRO()
          ? "Carro de paro"." - ".($carro_ubicacion ?? '')
          : "Revisi&oacute;n de Estante"." - ".($carro_nombre ?? '')
        ?> </span>
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
