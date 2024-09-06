<div class="fixed-bottom bg-blue-main d-flex d-lg-none p-1 justify-content-between">
  <details class="position-relative" @click.outside="$el.removeAttribute('open')">
    <summary class="btn btn-sm btn-light text-sm">
      <?= $this->isRoute("carros.index") ? "Carros" : "Estantes" ?>
    </summary>
    <nav
    style="width: 230px; max-height: 70vh; border-color: var(--color-main) !important;"
    class="position-absolute rounded-top border-bottom-0 border shadow bottom-100 d-flex flex-column gap-1 small bg-light p-2 mb-1 overflow-auto"
    role="menu">
      <template x-for="carro in carros" :key="carro.id">
        <button
        type="button"
        role="menuitem"
        :class="{
          'active disabled': selected === carro.id,
          'disabled': carroStatus
        }"
        @click="carroClicked( carro.id )"
        class="rounded-1 align-items-center btn btn-sm carro-nav-item d-flex gap-2">
          <?= $this->fetch("./icons/bookmark.php") ?>
          <span>
            <span
            class="d-block"
            x-text="carro.nombre"></span>
            <span
            class="fw-light small d-block"
            x-text="carro.ubicacion"></span>
          </span>
        </button>
      </template>

      <?= $this->fetch("./partials/sidebar/unsaved-car-message.php") ?>
      <?= $this->fetch("./partials/sidebar/no-carros.php") ?>
    </nav>
  </details>

  <a
    href="<?= $this->link("excel.all", [
      "tipo" => $this->isRoute("carros.index")
        ? \App\Enums\CarroTipo::CARRO()
        : \App\Enums\CarroTipo::ESTANTE()
    ]) ?>"
    download
    class="btn btn-sm btn-success text-sm"
  >
    Excel
    <?= $this->fetch("./icons/excel.php") ?>
  </a>

  <div x-data="{ __getPrintWeb: () => '<?= $this->link("print.all", [
      "tipo" => $this->isRoute("carros.index")
        ? \App\Enums\CarroTipo::CARRO()
        : \App\Enums\CarroTipo::ESTANTE()
    ]) ?>' }">
    <button
      x-data="print"
      @click="__print"
      class="btn btn-sm btn-warning text-sm w-100"
    >
      Imprimir Todos
      <?= $this->fetch("./icons/print.php") ?>
    </button>
  </div>

  <?php if ($this->can("carro.create")) : ?>
    <?= $this->fetch("./partials/sidebar/create-carro.php") ?>
  <?php endif ?>
</div>
