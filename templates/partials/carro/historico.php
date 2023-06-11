<div x-data="historico">
  <h5
  class="text-center">
    Registro de Cambios
    <span x-text="getModel()"></span>
  </h5>
  <!-- Selects de Cambios -->
  <div class="d-flex gap-2 justify-content-between">
    <div class="text-sm">
      <label class="form-label text-muted">Cambios en Medicamentos:</label>
      <select
      @change="changeSelected(<?= \App\Services\HistoricoService::MEDICAMENTO ?>, $el.value)"
      class="form-control form-control-sm">
        <option hidden selected> Cambio </option>
        <template x-for="cambio in changesList.medicamentos">
          <option
          :value="cambio.id"
          x-text="`${cambio.fecha} | ${cambio.hora}`"></option>
        </template>
      </select>
    </div>

    <div class="text-sm">
      <label class="form-label text-muted">Cambios en Dispositivos:</label>
      <select
      @change="changeSelected(<?= \App\Services\HistoricoService::DISPOSITIVO ?>, $el.value)"
      class="form-control form-control-sm">
        <option hidden selected> Cambio </option>
        <template x-for="cambio in changesList.dispositivos">
          <option
          :value="cambio.id"
          x-text="`${cambio.fecha} | ${cambio.hora}`"></option>
        </template>
      </select>
    </div>
  </div>

  <!-- Container de Cambios -->
  <template x-if="Boolean(changes)">
    <div class="d-grid" style="grid-template-columns: 1fr auto 1fr;">
      <div class="p-3">
        <h6 class="text-center">Antes</h6>
        <ul class="list-group text-sm">
          <template x-for="antes in changes.before">
            <li class="list-group-item list-group-item-light d-flex">
              <span
              class="flex-grow-1"
              x-text="antes.p_activo_concentracion"></span>
              <span
              x-text="antes.cantidad"></span>
            </li>
          </template>
        </ul>
      </div>
      <div class="border"></div>
      <div class="p-3">
        <h6 class="text-center">Despu&eacute;s</h6>
        <ul class="list-group text-sm">
          <template x-for="desp in changes.after">
            <li class="list-group-item list-group-item-primary d-flex">
              <span
              class="flex-grow-1"
              x-text="desp.p_activo_concentracion"></span>
              <span
              x-text="desp.cantidad"></span>
            </li>
          </template>
        </ul>
      </div>
    </div>
  </template>
</div>
