<header class="bg-blue-dark">
  <div class="container p-2">
    <img
    height="40"
    src="<?= $this->asset("img/logo-blanco.png") ?>"
    alt="logo-asotrauma">
  </div>
  <div class="text-center p-1 bg-blue-main">
    <a
    href="<?= $this->link("carros.index") ?>"
    class="btn btn-outline-light btn-sm border-0
    <?= $this->isRoute('carros.index') ? 'active' : '' ?>">
      Carros de Paro
    </a>

    <a
    href="<?= $this->link("carros.buscar-historico") ?>"
    class="btn btn-outline-light btn-sm border-0
    <?= $this->isRoute('carros.buscar-historico') ? 'active' : '' ?>">
      Buscar en Hist&oacute;rico
    </a>
  </div>
</header>
