<header class="bg-blue-dark">
  <div class="container p-2 d-flex align-items-center justify-content-between">
    <img
    height="35"
    src="<?= $this->asset("img/logo-blanco.png") ?>"
    alt="logo-asotrauma">
    <span class="badge text-bg-light fs-6">
      <?= $_data["carro_nombre"] ?? '' ?>
    </span>
  </div>
</header>
