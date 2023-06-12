<div
x-data="createDispositivo"
x-bind="events"
x-show="show"
x-cloak
class="fixed-top vw-100 vh-100 bg-black bg-opacity-75">
  <div
  style="width: 80%; max-width: 500px; max-height: 80%;"
  class="mt-4 mx-2 bg-body mx-auto rounded-1 overflow-auto d-flex flex-column">
    <h5 class="border-bottom text-center p-2 m-0">Dispositivo</h5>
    <form
    id="create-dispositivo"
    @submit.prevent="guardar"
    class="small d-grid gap-2 p-3 m-0 overflow-auto"
    style="grid-template-columns: repeat(auto-fit, minmax(230px, 1fr));"
    autocomplete="off">
      <div>
        <label
        for="new-dispositivo-desc"
        class="form-label small text-muted"
        >Descripci&oacute;n:</label>
        <input
        id="new-dispositivo-desc"
        x-model="state.desc"
        type="text"
        minlength="3"
        required
        autofocus
        class="form-control form-control-sm">
      </div>

      <div>
        <label
        for="new-dispositivo-marca"
        class="form-label small text-muted">Marca:</label>
        <input
        id="new-dispositivo-marca"
        x-model="state.marca"
        type="text"
        required
        class="form-control form-control-sm">
      </div>

      <div>
        <label
        for="new-dispositivo-presentacion"
        class="form-label small text-muted">Presentaci&oacute;n:</label>
        <input
        id="new-dispositivo-presentacion"
        x-model="state.presentacion"
        type="text"
        required
        class="form-control form-control-sm">
      </div>

      <div>
        <label
        for="new-dispositivo-invima"
        class="form-label small text-muted">Invima:</label>
        <input
        id="new-dispositivo-invima"
        x-model="state.invima"
        type="text"
        required
        class="form-control form-control-sm">
      </div>

      <div>
        <label
        for="new-dispositivo-lote"
        class="form-label small text-muted">Lote:</label>
        <input
        id="new-dispositivo-lote"
        x-model="state.lote"
        type="text"
        required
        class="form-control form-control-sm">
      </div>

      <div>
        <label
        for="new-dispositivo-vencimiento"
        class="form-label small text-muted">Fecha de Vencimiento:</label>
        <input
        id="new-dispositivo-vencimiento"
        x-model="state.vencimiento"
        type="date"
        class="form-control form-control-sm">
      </div>

      <div>
        <label
        for="new-dispositivo-vida-util"
        class="form-label small text-muted">Vida &uacute;til:</label>
        <input
        id="new-dispositivo-vida-util"
        x-model.number="state.vida_util"
        type="text"
        required
        class="form-control form-control-sm">
      </div>

      <div>
        <label
        for="new-dispositivo-cantidad"
        class="form-label small text-muted">Cantidad:</label>
        <input
        id="new-dispositivo-cantidad"
        x-model.number="state.cantidad"
        type="number"
        min="0"
        required
        class="form-control form-control-sm">
      </div>

      <div>
        <label
        for="new-dispositivo-riesgo"
        class="form-label small text-muted">Riesgo:</label>
        <input
        id="new-dispositivo-riesgo"
        x-model.number="state.riesgo"
        type="text"
        required
        class="form-control form-control-sm">
      </div>
      <template x-if="isEdit">
        <div>
          <label
          for="motivo-edicion"
          class="form-label small text-muted">Motivo Modificaci&oacute;n:</label>
          <select
          required
          x-model="state.motivo_edicion"
          id="motivo-edicion"
          class="form-control form-control-sm">
            <option value="" selected hidden>-- Motivo --</option>
            <option value="Motivo 1">Motivo 1</option>
            <option value="Motivo 2">Motivo 2</option>
            <option value="Motivo 3">Motivo 3</option>
          </select>
        </div>
      </template>
    </form>

    <div class="d-flex justify-content-between border-top p-1">
      <button
      @click="close"
      type="button"
      class="btn btn-sm text-sm btn-outline-danger">Cancelar</button>

      <button
      x-data="deleteDispositivo"
      @click="delDisp"
      x-show="showButton"
      class="btn btn-sm text-sm btn-danger">
        <?= $this->fetch("./icons/trash.php") ?>
        Eliminar
      </button>

      <button
      form="create-dispositivo"
      type="submit"
      class="btn btn-sm text-sm btn-success">Guardar</button>
    </div>
  </div>
</div>
