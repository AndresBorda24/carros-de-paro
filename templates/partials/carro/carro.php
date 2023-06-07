<div x-data="carro" x-bind="events" class="p-3 p-md-4">
  <div class="d-flex align-items-center flex-wrap border-bottom p-1 mb-3">
    <div class="flex-grow-1 gap-1 text-center d-flex justify-content-center align-items-center">
      <h5
      class="m-0"
      x-text="getCarroNombre() || 'Selecciona un Carro'"></h5>
      <span
      role="button"
      x-show="hasCarro"
      x-cloak
      class="text-sm text-success">
        <?= $this->fetch("./icons/edit.php") ?>
      </span>
    </div>
    <button
    type="button"
    x-show="hasCarro"
    x-cloak
    class="btn btn-danger btn-sm text-sm">
      <?= $this->fetch("./icons/trash.php") ?>
      <span class="d-none d-md-inline">Eliminar</span>
    </button>
  </div>

  <template x-if="hasCarro">
    <div class="btn-group mb-3" role="group">
      <button
      type="button"
      @click="grillaShow = 1"
      :class="{'active': grillaShow === 1}"
      class="btn btn-outline-primary btn-sm text-sm active">Medicamentos</button>
      <button
      type="button"
      @click="grillaShow = 2"
      :class="{'active': grillaShow === 2}"
      class="btn btn-outline-primary btn-sm text-sm">Dispositivos</button>
    </div>
  </template>


  <div x-show="grillaShow === 1">
    <?= $this->fetch("./partials/carro/grillas/medicamentos.php") ?>
  </div>

  <div x-show="grillaShow === 2">
    <?= $this->fetch("./partials/carro/grillas/dispositivos.php") ?>
  </div>
</div>
