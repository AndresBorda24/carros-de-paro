<div
x-data="carrosList(<?= $this->isRoute("carros.estantes") ? 'true' : 'false' ?>)"
x-bind="events"
class="position-sticky top-0">
  <div class="d-none d-lg-block p-3">
    <h5>Listado de <?= $this->isRoute("carros.estantes") ? "Estantes" : "Carros" ?>:</h5>

    <div class="mb-2">
      <div x-data="{ __getPrintWeb: () => '<?= $this->link("print.all", [
          "tipo" => $this->isRoute("carros.index")
            ? \App\Enums\CarroTipo::CARRO()
            : \App\Enums\CarroTipo::ESTANTE()
        ]) ?>' }" >
        <button
          x-data="print"
          @click="__print"
          class="btn btn-sm btn-dark text-sm w-100"
        >
          Imprimir Todos
          <?= $this->fetch("./icons/print.php") ?>
        </button>
      </div>

      <a
        href="<?= $this->link("excel.all", [
          "tipo" => $this->isRoute("carros.index")
            ? \App\Enums\CarroTipo::CARRO()
            : \App\Enums\CarroTipo::ESTANTE()
        ]) ?>"
        download
        class="btn btn-sm btn-success text-sm w-100"
      >
        Excel
        <?= $this->fetch("./icons/excel.php") ?>
      </a>
    </div>

    <!-- Funciona como un loader chiquito -->
    <img
    id="carro-list-loader"
    width="40"
    style="display: block;"
    class="d-none m-auto"
    src="<?= $this->asset("img/loader-1.png") ?>"
    alt="loader-list">

    <nav
      style="max-height: 60vh;"
      class="d-flex flex-column gap-1 mb-3 overflow-auto"
      role="menu"
    >
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
    </nav>

    <?= $this->fetch("./partials/sidebar/no-carros.php") ?>

    <?php if ($this->can("carro.create")) : ?>
      <?= $this->fetch("./partials/sidebar/create-carro.php") ?>
    <?php endif ?>
  </div>

  <!-- Movemos el nav para main y asi evitamos overlapping -->
  <template x-teleport="main">
    <?= $this->fetch("./partials/sidebar/mobile.php") ?>
  </template>
</div>
