<div
x-data="carrosList"
x-bind="events"
class="position-sticky top-0 p-3">
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
    <template x-for="id in Object.keys(carros)" :key="id">
      <button
      type="button"
      role="menuitem"
      class="rounded-1 align-items-center btn btn-sm carro-nav-item d-flex gap-2">
        <?= $this->fetch("./icons/bookmark.php") ?>
        <span>
          <span
          class="d-block"
          x-text="carros[ id ].nombre"></span>
          <span
          class="fw-light small d-block"
          x-text="carros[ id ].ubicacion"></span>
        </span>
      </button>
    </template>
  </nav>

  <button
  @click="$dispatch('create-carro')"
  style="font-size: .7rem;"
  class="btn btn-outline-success btn-sm text-end ms-auto d-block">
    <?= $this->fetch("./icons/plus.php") ?>
    Nuevo Carro
  </button>
</div>
