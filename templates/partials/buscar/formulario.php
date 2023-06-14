<form
x-data="formulario"
class="d-flex flex-wrap align-items-center"
@submit.prevent="fetchList"
autocomplete="off">
  <div class="col-12 col-md-4 d-flex gap-3 px-2">
    <div class="d-flex flex-column gap-1">
      <label
      for="model-medicamento"
      :class="(state.model == '<?= \App\Services\HistoricoService::MEDICAMENTO ?>')
        ? 'active' : ''
      "
      class="btn btn-sm btn-outline-primary text-sm px-3">
        <input
        type="radio"
        name="model"
        x-model="state.model"
        required
        value="<?= \App\Services\HistoricoService::MEDICAMENTO ?>"
        class="visually-hidden"
        id="model-medicamento">
        Medicamento
      </label>

      <label
      for="model-dispositivo"
      :class="(state.model == '<?= \App\Services\HistoricoService::DISPOSITIVO ?>')
        ? 'active' : ''
      "
      class="btn btn-sm btn-outline-primary text-sm px-3">
        <input
        type="radio"
        name="model"
        x-model="state.model"
        class="visually-hidden"
        value="<?= \App\Services\HistoricoService::DISPOSITIVO ?>"
        id="model-dispositivo">
        Dispositivo
      </label>
    </div>

    <div class="flex-grow-1">
      <label for="field" class="text-muted small form-label m-0">Buscar Por:</label>
      <select
      name="field"
      id="field"
      required
      x-model="state.field"
      class="form-select form-select-sm">
        <option value="" hidden selected>Selecciona</option>
        <option value="invima">Invima</option>
        <option value="lote">Lote</option>
        <option value="nombre">Nombre</option>
      </select>
    </div>
  </div>

  <div class="col-12 col-md-8 d-flex gap-3 align-items-center px-2 mt-1 mt-md-0">
    <div class="flex-grow-1">
      <label for="query" class="text-muted small form-label m-0">Valor:</label>
      <input
      required
      x-model="state.query"
      type="text"
      id="query"
      name="query"
      placeholder="Escribe lo que quieras buscar..."
      class="form-control form-control-sm">
    </div>
    <button class="btn btn-success btn-sm">
      <span class="text-sm">
        <?= $this->fetch('./icons/right-dashed.php') ?>
      </span>
    </button>
  </div>
</form>
