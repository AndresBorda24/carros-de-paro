<div x-data="carro" x-bind="events" class="p-3 p-md-4">
  <h5
  class="text-center border-bottom"
  x-text="getCarroNombre() || 'Selecciona un Carro'"></h5>

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
  </div>
</div>
