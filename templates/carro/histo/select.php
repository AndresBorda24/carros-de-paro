<div class="small p-2 border bg-body-tertiary rounded">
  <label for="histo-select" class="form-label text-muted small">
    Selecciona la apertura que deseas revisar:
  </label>
  <select
  id="histo-select"
  x-data="histoSelect"
  x-bind="events"
  @change="aperturaSelected( $el.value )"
  class="form-select form-select-sm">
    <option value="" hidden selected>-- Selecciona --</option>
    <template x-for="ap in aperturas" :key="ap.id">
      <option
      :value="ap.id"
      x-text="`${ap.fecha} | ${ap.hora}`"
      ></option>
    </template>
  </select>
</div>
