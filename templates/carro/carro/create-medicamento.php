<div
x-data="createMedicamento"
x-bind="events"
x-show="show" x-transition.opacity x-cloak
@items-orderd="setState($event.detail)"
class="fixed-top vw-100 vh-100 bg-black bg-opacity-75 overflow-auto">
  <div
  style="width: 80%; max-width: 400px;"
  class="my-4 mx-2 bg-body mx-auto rounded-1 d-flex flex-column border border-2 border-success">
    <h5 class="border-bottom text-center p-2 m-0 fw-bold">Medicamento</h5>
    <form
    id="create-medicamento"
    @submit.prevent="guardar"
    class="bg-body-tertiary gap-3 p-3 overflow-auto d-flex flex-column position-relative"
    autocomplete="off">

      <?= true ? "" : $this->fetch("./carro/carro/copy-excel.php", [ // true ? "" para que no se cargue xD
        "listId" => "dis-list",
        "items"  => [
          "p_activo_concentracion" => "Principio Activo / Concentración",
          "forma_farma"            => "Forma Farmacéutica",
          "medida"                 => "Unidad de Medida",
          "presentacion"           => "Presentación Comercial",
          "invima"                 => "Invima",
          "lote"                   => "Lote",
          "vencimiento"            => "Fecha de Vencimiento",
        ]
      ]) ?>

      <div>
        <label
        for="new-medicamento-p-activo"
        class="form-label m-0 small"
        >Principio Activo / Concentraci&oacute;n:</label>
        <input
        id="new-medicamento-p-activo"
        x-model="state.p_activo_concentracion"
        type="text"
        minlength="3"
        required
        autofocus
        class="form-control form-control-sm">
      </div>

      <div>
        <label
        for="new-medicamento-forma-farma"
        class="form-label m-0 small">Forma Farmac&eacute;utica:</label>
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
        class="form-label m-0 small">Unidad de Medida:</label>
        <input
        id="new-medicamento-medida"
        x-model="state.medida"
        type="text"
        required
        class="form-control form-control-sm">
      </div>

      <div>
        <label
        for="new-medicamento-presentacion"
        class="form-label m-0 small">Presentaci&oacute;n Comercial:</label>
        <input
        id="new-medicamento-presentacion"
        x-model="state.presentacion"
        type="text"
        required
        class="form-control form-control-sm">
      </div>

        <?php if ($this->isRoute("carros.estantes")): ?>
        <div>
          <label
          for="new-medicamento-nombre-com"
          class="form-label m-0 small">Nombre Comercial:</label>
          <input
          id="new-medicamento-nombre-com"
          x-model="state.nombre_comercial"
          type="text"
          required
          class="form-control form-control-sm">
        </div>
      <?php endif ?>

      <div>
        <label
        for="new-medicamento-invima"
        class="form-label m-0 small">Invima:</label>
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
        class="form-label m-0 small">Lote:</label>
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
        class="form-label m-0 small">Fecha de Vencimiento:</label>
        <input
        id="new-medicamento-vencimiento"
        x-model="state.vencimiento"
        type="date"
        required
        class="form-control form-control-sm">
      </div>

      <?php if($this->isRoute("carros.index") || $this->isRoute("carros.kits")): ?>
        <div>
          <label
          for="new-medicamento-cantidad"
          class="form-label m-0 small">Cantidad:</label>
          <input
          required
          min="0"
          id="new-medicamento-cantidad"
          x-model.number="state.cantidad"
          type="number"
          class="form-control form-control-sm">
        </div>
      <?php endif ?>

      <?= $this->fetch("./carro/historico/select-motivos.php") ?>
    </form>

    <div class="d-flex justify-content-between border-top p-2">
      <button
      tabindex="-1"
      type="button"
      @click="close"
      class="btn btn-sm btn-dark">Cancelar</button>

      <?php if($this->can("medicamentos.delete")): ?>
          <button
                  tabindex="-1"
                  @click="delMed"
                  x-show="isEdit"
                  x-data="deleteMedicamento"
                  class="btn btn-sm btn-danger flex items-center gap-2"
          >
              <?= $this->fetch("./icons/trash.php") ?>
              <span>Eliminar</span>
          </button>
      <?php endif ?>

      <button
      form="create-medicamento"
      type="submit"
      class="btn btn-sm btn-success">Guardar</button>
    </div>
  </div>
</div>
