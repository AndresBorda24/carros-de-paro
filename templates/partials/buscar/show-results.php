<div
x-data="showResults"
x-bind="events">
  <select x-show="show" x-cloak name="" id="">
    <template x-for="d in data" :key="d.id">
      <option
      value="d.id"
      x-text="`${d.fecha} | ${d.hora}`"></option>
    </template>
  </select>
</div>
