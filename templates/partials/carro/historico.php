<div
x-data="historico"
x-bind="events"
class="p-2 border rounded bg-body">
  <h5
  class="text-center">
    Registro de Cambios
    <span
    class="badge"
    :class="{
      'text-bg-primary': isMed(),
      'text-bg-warning': isDisp()
    }"
    x-text="getModel()"></span>
  </h5>

  <!-- Selects de Cambios -->
  <div class="d-flex gap-2 justify-content-between">
    <div class="text-sm p-1 rounded text-bg-primary bg-opacity-25">
      <label class="form-label text-muted">Cambios en Medicamentos:</label>
      <select
      @change="changeSelected('<?= \App\Services\HistoricoService::MEDICAMENTO ?>', $el.value)"
      class="form-control form-control-sm">
        <option hidden selected value=""> Selecciona </option>
        <template x-for="cambio in changesList.medicamentos">
          <option
          :value="cambio.id"
          x-text="`${cambio.fecha} | ${cambio.hora}`"></option>
        </template>
      </select>
    </div>

    <div class="text-sm p-1 rounded text-bg-warning bg-opacity-25">
      <label class="form-label text-muted">Cambios en Dispositivos:</label>
      <select
      @change="changeSelected('<?= \App\Services\HistoricoService::DISPOSITIVO ?>', $el.value)"
      class="form-control form-control-sm">
        <option hidden selected value=""> Selecciona </option>
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
