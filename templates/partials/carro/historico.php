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
  <?= $this->fetch('./partials/carro/historico/comparacion.php') ?>
</div>
