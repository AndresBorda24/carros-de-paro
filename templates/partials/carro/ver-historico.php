<h6 class="text-center">Hist&oacute;rico</h6>
<div x-data="verHistorico">
  <!-- Filtro de Fechas -->
  <div class="d-flex align-items-center justify-content-center gap-2 flex-wrap
  text-sm p-2 border-bottom mb-3">
    <div class="small">
      <label for="histo-desde">Desde:</label>
      <input
      type="date"
      x-model="d.start"
      class="form-control form-control-sm">
    </div>
    <?= $this->fetch("./icons/right.php") ?>
    <div class="small">
      <label for="histo-desde">Hasta:</label>
      <input
      type="date"
      x-model="d.end"
      class="form-control form-control-sm">
    </div>
    <button
    @click="getData"
    class="btn btn-sm btn-secondary p-1 pt-0">
      <?= $this->fetch("./icons/search.php") ?>
    </button>
  </div>

  <!-- Listado -->
  <div
  style="max-height: 600px;"
  class="overflow-auto pb-5">
    <template x-for="(fecha, i) in Object.keys(data)" :key="i">
      <?= $this->fetch("./partials/carro/historico/list.php") ?>
    </template>
  </div>
</div>
