<div class="fixed-bottom bg-blue-main d-flex d-lg-none p-1 justify-content-between">
  <details class="position-relative">
    <summary class="btn btn-sm text-sm border-0 text-light">
      Carros
    </summary>
    <nav
    style="width: 230px;"
    class="position-absolute rounded-1 border shadow bottom-100
    d-flex flex-column gap-1 small bg-light p-2 mb-1"
    role="menu">
      <template x-for="id in Object.keys(carros)" :key="id">
        <button
        type="button"
        role="menuitem"
        :class="{'active': selected === id}"
        @click="carroClicked( id )"
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
  </details>

  <button
    @click="$dispatch('create-carro')"
    style="font-size: .7rem;"
    class="btn btn-success btn-sm text-end ms-auto d-block">
      <?= $this->fetch("./icons/plus.php") ?>
      Nuevo Carro
    </button>
</div>
