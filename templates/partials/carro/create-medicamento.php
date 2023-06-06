<div
x-data="createMedicamento"
x-bind="events"
x-show="show"
x-cloak
class="fixed-top vw-100 vh-100 bg-black bg-opacity-75">
  <div
  style="width: 80%; max-width: 500px; max-height: 80%;"
  class="mt-4 mx-2 p-2 bg-body mx-auto rounded-1 overflow-auto">
    <h5 class="border-bottom text-center">Adjuntar Medicamento</h5>
    <form
    id="create-medicamento"
    @submit.prevent="save"
    class="small d-grid gap-2"
    style="grid-template-columns: repeat(auto-fit, minmax(230px, 1fr));"
    autocomplete="off">
      <div>
        <label
        for="new-medicamento-p-activo"
        class="form-label small text-muted">Principio Activo:</label>
        <input
        id="new-medicamento-p-activo"
        x-model="state.p_activo"
        type="text"
        minlength="3"
        required
        autofocus
        class="form-control form-control-sm">
      </div>

      <div>
        <label
        for="new-medicamento-concentracion"
        class="form-label small text-muted">Concentraci&oacute;n:</label>
        <input
        id="new-medicamento-concentracion"
        x-model="state.concentracion"
        type="text"
        required
        class="form-control form-control-sm">
      </div>

      <div>
        <label
        for="new-medicamento-forma-farma"
        class="form-label small text-muted">Forma Farmac&eacute;utica:</label>
        <input
        id="new-medicamento-forma-farma"
        x-model="state.forma_farma"
        type="text"
        required
        class="form-control form-control-sm">
      </div>

      <div>
        <label
        for="new-medicamento-medida"
        class="form-label small text-muted">Medida:</label>
        <input
        id="new-medicamento-medida"
        x-model="state.medida"
        type="text"
        minlength="3"
        required
        class="form-control form-control-sm">
      </div>

      <div>
        <label
        for="new-medicamento-presentacion"
        class="form-label small text-muted">Presentaci&oacute;n:</label>
        <input
        id="new-medicamento-presentacion"
        x-model="state.presentacion"
        type="text"
        required
        class="form-control form-control-sm">
      </div>

      <div>
        <label
        for="new-medicamento-invima"
        class="form-label small text-muted">Invima:</label>
        <input
        id="new-medicamento-invima"
        x-model="state.invima"
        type="text"
        required
        class="form-control form-control-sm">
      </div>

      <div>
        <label
        for="new-medicamento-lote"
        class="form-label small text-muted">Lote:</label>
        <input
        id="new-medicamento-lote"
        x-model="state.lote"
        type="text"
        required
        class="form-control form-control-sm">
      </div>

      <div>
        <label
        for="new-medicamento-vencimiento"
        class="form-label small text-muted">Fecha de Vencimiento:</label>
        <input
        id="new-medicamento-vencimiento"
        x-model="state.vencimiento"
        type="date"
        required
        class="form-control form-control-sm">
      </div>

      <div>
        <label
        for="new-medicamento-cantidad"
        class="form-label small text-muted">Cantidad:</label>
        <input
        id="new-medicamento-cantidad"
        x-model="state.cantidad"
        type="number"
        min="0"
        required
        class="form-control form-control-sm">
      </div>

    </form>
    <div class="d-flex justify-content-between mt-3 border-top p-1">
      <button
      @click="close"
      type="button"
      class="btn btn-sm text-sm btn-danger">Cancelar</button>
      <button
      form="create-medicamento"
      type="submit"
      class="btn btn-sm text-sm btn-success">Crear</button>
    </div>
  </div>
</div>
