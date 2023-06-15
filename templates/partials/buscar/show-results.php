<div
x-data="showResults"
x-bind="events"
class="p-2"
x-show="Boolean(data)">
    <p class="m-2">
      Coincidencias encontradas:
      <span class="text-muted fw-bold" x-text="resultCount"></span>
    </p>
    <select
    x-show="show"
    x-cloak
    @change="changed($el.value)"
    class="form-select form-select-sm">
      <option value="" selected hidden>-- Selecciona --</option>
      <template x-for="d in data" :key="d.id">
        <option
        :value="d.id"
        x-text="`${d.fecha} | ${d.hora}`"></option>
      </template>
    </select>
</div>
