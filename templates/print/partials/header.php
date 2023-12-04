<thead>
  <tr>
    <th class=" d-flex align-items-center justify-content-between">
      <img
      height="35"
      src="<?= $this->asset("img/logo.png") ?>"
      alt="logo-asotrauma">
      <span class="badge text-bg-light rounded-1 fw-medium">
        <span> <?= $_data["tipo"] == \App\Enums\CarroTipo::CARRO()
          ? "Carro de paro"
          : "Revisi&oacute;n de Estante"
        ?> - </span> <?= $_data["carro_ubicacion"] ?? '' ?>
      </span>
    </th>
  </tr>
  <tr>
    <th class="small text-muted">
      <span class="small">
        Revisi&oacute;n <?= $_data["usuario"] ?> | <?= $_data["fecha"] ?>
      </span>
    </th>
  </tr>
</thead>
