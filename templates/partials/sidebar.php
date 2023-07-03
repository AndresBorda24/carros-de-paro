<div
x-data="carrosList"
x-bind="events"
class="position-sticky top-0">
  <div class="d-none d-lg-block p-3">
    <h5>Listado de Carros:</h5>

    <!-- Funciona como un loader chiquito -->
    <img
    id="carro-list-loader"
    width="40"
    style="display: block;"
    class="d-none m-auto"
    src="<?= $this->asset("img/loader-1.png") ?>"
    alt="loader-list">

    <nav class="d-flex flex-column gap-1 mb-3" role="menu">
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
