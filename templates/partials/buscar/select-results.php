<div
x-data="selectResults"
x-bind="events"
x-show="show"
x-cloak
class="p-3 border"
x-show="Boolean(data)">
  <p class="m-2">
    Coincidencias encontradas:
    <span class="text-muted fw-bold" x-text="resultCount"></span>
  </p>
  <select
  x-show="show"
  x-cloak
  x-model="historicoId"
  class="form-select form-select-sm mb-3">
    <option value="" selected hidden>-- Selecciona --</option>
    <template x-for="d in data" :key="d.id">
      <option
      :value="d.id"
      x-text="`${d.nombre} | ${d.fecha} | ${d.hora}`"></option>
    </template>
  </select>

  <?= $this->fetch("./partials/buscar/show.php") ?>
</div>
