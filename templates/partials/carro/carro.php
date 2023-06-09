<div x-data="carro" x-bind="events" class="p-3 p-md-4 mb-4">

  <!-- Titulo y Boton de Eliminar -->
  <div class="d-flex align-items-center flex-wrap border-bottom p-1 mb-3">
    <div class="flex-grow-1 gap-1 text-center d-flex justify-content-center align-items-center">
      <h5
      class="m-0"
      x-text="getCarroNombre() || 'Selecciona un Carro'"></h5>

      <!-- Boton de Editar Carro -->
      <span
      role="button"
      @click="$dispatch('update-carro', getCarroFull())"
      x-show="hasCarro"
      x-cloak
      class="text-sm text-success">
        <?= $this->fetch("./icons/edit.php") ?>
      </span>
    </div>

    <!-- Eliminar Carro -->
    <button
    type="button"
    @click="delCarro"
    x-show="hasCarro"
    x-data="deleteCarro"
    x-cloak
    class="btn btn-danger btn-sm text-sm">
      <?= $this->fetch("./icons/trash.php") ?>
      <span class="d-none d-md-inline">Eliminar</span>
    </button>
  </div>


  <!-- 'Nav' (medicamentos-dispositivos) y detalles de colores -->
  <div class="d-flex flex-wrap mb-3 justify-content-between">
    <!-- Nav -->
    <template x-if="hasCarro">
      <div class="btn-group" role="group">
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
        <button
        type="button"
        @click="grillaShow = 3"
        :class="{'active': grillaShow === 3}"
        class="btn btn-outline-primary btn-sm text-sm">Hist&oacute;rico</button>
      </div>
    </template>

    <details
    x-cloak
    x-show="hasCarro"
    class="position-relative">
      <summary class="text-sm btn">
          &iquest;Ayuda con los colores?
          <?= $this->fetch("./icons/question.php") ?>
      </summary>

      <ul
      style="width: 210px; z-index: 1;"
      class="list-group list-group-flush position-absolute text-sm end-0
      top-100 shadow border border-secondary rounded-1 mt-1">
        <li class="list-group-item list-group-item-success">
          M&aacute;s a 12 Meses
        </li>
        <li class="list-group-item list-group-item-warning">
          Entre 7 y 12 Meses
        </li>
        <li class="list-group-item list-group-item-danger">
          Menos de 7 meses
        </li>
      </ul>
    </details>
  </div>

  <!-- Grillas -->
  <div x-show="grillaShow === 1">
    <?= $this->fetch("./partials/carro/grillas/medicamentos.php") ?>
  </div>

  <div x-show="grillaShow === 2">
    <?= $this->fetch("./partials/carro/grillas/dispositivos.php") ?>
  </div>

  <div x-show="grillaShow === 3">
    <?= $this->fetch("./partials/carro/ver-historico.php") ?>
  </div>
</div>
