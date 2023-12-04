<div class="fixed-bottom bg-blue-main d-flex d-lg-none p-1 justify-content-between">
  <details class="position-relative" @click.outside="$el.removeAttribute('open')">
    <summary class="btn btn-sm btn-outline-light text-sm">
      <?= $this->isRoute("carros.index") ? "Carros" : "Estantes" ?>
    </summary>
    <nav
    style="width: 230px; border-color: var(--color-main) !important;"
    class="position-absolute rounded-top border-bottom-0 border shadow bottom-100
    d-flex flex-column gap-1 small bg-light p-2 mb-1"
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

  <?php if ($this->can("carro.create")) : ?>
    <?= $this->fetch("./partials/sidebar/create-carro.php") ?>
  <?php endif ?>
</div>
