<div x-data="carro" x-bind="events" class="p-2 p-md-3 mb-5">

  <!-- Titulo y Boton de Eliminar -->
  <div class="d-flex align-items-center flex-wrap border-bottom p-1 mb-3
  bg-body-tertiary sticky-top">
    <div class="flex-grow-1 gap-1 text-center d-flex justify-content-center align-items-center">
      <h5
      class="m-0"
      x-text="getCarroNombre() || 'Selecciona un Carro'"></h5>

      <!-- Boton de Editar Carro -->
      <?php if($this->can('carro.edit')): ?>
        <span
        role="button"
        @click="$dispatch('update-carro', getCarroFull())"
        x-show="hasCarro"
        x-cloak
        class="text-sm text-success">
          <?= $this->fetch("./icons/edit.php") ?>
        </span>
      <?php endif ?>

      <!-- Boton de Editar Carro -->
      <?php if($this->can('carro.modify')): ?>
        <template x-if="hasCarro">
          <?= $this->fetch("./carro/carro/create-apertura.php") ?>
        </template>
      <?php endif ?>
    </div>

    <?php if($this->can('carro.delete')): ?>
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
    <?php endif ?>
  </div>


  <!-- 'Nav' (medicamentos-dispositivos) y detalles de colores -->
    <!-- Nav -->
  <template x-if="hasCarro">
    <div class="d-flex flex-wrap mb-3 gap-2 align-items-center">
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
      </div>

      <button
      x-cloak
      x-show="hasCarro"
      type="button"
      @click="grillaShow = 3"
      class="btn btn-warning btn-sm text-sm">Hist&oacute;rico</button>

      <button
        x-data="print"
        @click="__print"
        class="btn btn-sm btn-dark text-sm"
      >
        Imprimir
        <?= $this->fetch("./icons/print.php") ?>
      </button>



      <details
      x-cloak
      x-show="(grillaShow == 1 || grillaShow == 2)"
      @click.outside="$el.removeAttribute('open')"
      class="position-relative ms-auto z-2">
        <summary class="text-sm btn btn-sm">
            &iquest;Ayuda con los colores?
            <?= $this->fetch("./icons/question.php") ?>
        </summary>
        <ul
        style="width: 150px; z-index: 1;"
        class="list-group list-group-flush position-absolute text-sm end-0
        top-100 shadow border border-secondary rounded-1 mt-1">
          <li class="list-group-item list-group-item-success p-1">
            M&aacute;s a 12 Meses
          </li>
          <li class="list-group-item list-group-item-warning p-1">
            Entre 7 y 12 Meses
          </li>
          <li class="list-group-item list-group-item-danger p-1">
            Menos de 7 meses
          </li>
        </ul>
      </details>
    </div>
  </template>

  <!-- Grillas -->
  <div class="position-relative z-1" x-show="grillaShow === 1">
    <?= $this->fetch("./carro/grillas/medicamentos.php") ?>
  </div>

  <div class="position-relative z-1" x-show="grillaShow === 2">
    <?= $this->fetch("./carro/grillas/dispositivos.php") ?>
  </div>

  <!-- Historico -->
  <div class="position-relative z-1" x-show="grillaShow === 3">
    <?= $this->fetch("./carro/histo/historico.php") ?>
  </div>
</div>
