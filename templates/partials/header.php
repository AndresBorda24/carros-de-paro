<header class="bg-blue-dark">
    <div class="container p-2">
        <a
                class="d-block"
                href="https://intranet.asotrauma.com.co/indexloginadmin.php">
            <img
                    class="w-41"
                    src="<?= $this->asset("img/logo-blanco.png") ?>"
                    alt="logo-asotrauma">
        </a>
    </div>
    <div class="d-flex justify-content-center gap-2 p-1 bg-blue-main">
        <a
                href="<?= $this->link("carros.index") ?>"
                class="btn btn-outline-light btn-sm border-0
    <?= $this->isRoute('carros.index') ? 'active' : '' ?>">
            Carros
        </a>

        <a
                href="<?= $this->link("carros.estantes") ?>"
                class="btn btn-outline-light btn-sm border-0
    <?= $this->isRoute('carros.estantes') ? 'active' : '' ?>">
            Estantes
        </a>

        <a
                href="<?= $this->link("carros.kits") ?>"
                class="btn btn-outline-light btn-sm border-0
    <?= $this->isRoute('carros.kits') ? 'active' : '' ?>">
            Kits
        </a>

        <div class="border-start"></div>

        <a
                href="<?= $this->link("carros.buscar-historico") ?>"
                class="btn btn-outline-light btn-sm border-0
    <?= $this->isRoute('carros.buscar-historico') ? 'active' : '' ?>">
            Buscar en Hist&oacute;rico
        </a>
    </div>
</header>
