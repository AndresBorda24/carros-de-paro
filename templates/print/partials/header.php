<header class="bg-blue-dark">
  <div class="container p-2 d-flex align-items-center justify-content-between">
    <img
    height="35"
    src="<?= $this->asset("img/logo-blanco.png") ?>"
    alt="logo-asotrauma">
    <span class="badge text-bg-light rounded-1 fw-medium">
      <span >Carro de paro - </span> <?= $_data["carro_ubicacion"] ?? '' ?>
    </span>
  </div>
</header>
