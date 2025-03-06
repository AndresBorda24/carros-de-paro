<div
x-data="createDispositivo"
x-bind="events"
x-show="show" x-transition.opacity x-cloak
class="fixed-top vw-100 vh-100 bg-black bg-opacity-75 overflow-auto">
  <div
  style="width: 80%; max-width: 400px;"
  class="my-4 mx-2 bg-body mx-auto rounded-1 border border-2 border-success d-flex flex-column">
    <h5 class="border-bottom text-center p-2 m-0 fw-bold">Dispositivo</h5>
    <form
    id="create-dispositivo"
    @submit.prevent="guardar"
    class="d-flex flex-column position-relative bg-body-tertiary gap-3 p-3 m-0 overflow-auto"
    autocomplete="off">
      <?= true ? "" : $this->fetch("./carro/carro/copy-excel.php", [
        "listId" => "dis-list",
        "items"  => [
          "desc"          => "Descripción",
          "marca"         => "Marca",
          "presentacion"  => "Presentación",
          "invima"        => "Invima",
          "lote"          => "Lote",
          "vencimiento"   => "Fecha de Vencimiento",
          "vida_util"     => "Vida Util",
          "cantidad"      => "Cantidad",
          "riesgo"        => "Riesgo"
        ]
      ]) ?>

      <div>
        <label
        for="new-dispositivo-desc"
        class="form-label m-0 small"
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
        class="form-label m-0 small">Marca:</label>
        <input
        id="new-dispositivo-marca"
        x-model="state.marca"
        type="text"
        required
        class="form-control form-control-sm">
      </div>

      <?php if($this->isRoute("carros.estantes")): ?>
        <div>
          <label
          for="new-dispositivo-serie"
          class="form-label m-0 small">Serie:</label>
          <input
          id="new-dispositivo-serie"
          x-model="state.serie"
          type="text"
          required
          class="form-control form-control-sm">
        </div>
      <?php endif ?>

      <div>
        <label
        for="new-dispositivo-presentacion"
        class="form-label m-0 small">Presentaci&oacute;n:</label>
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
        class="form-label m-0 small">Invima:</label>
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
        class="form-label m-0 small">Lote:</label>
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
        class="form-label m-0 small">Fecha de Vencimiento:</label>
        <input
        id="new-dispositivo-vencimiento"
        x-model="state.vencimiento"
        type="date"
        class="form-control form-control-sm">
      </div>

      <div>
        <label
        for="new-dispositivo-vida-util"
        class="form-label m-0 small">Vida &uacute;til:</label>
        <input
        id="new-dispositivo-vida-util"
        x-model="state.vida_util"
        type="text"
        required
        class="form-control form-control-sm">
      </div>

      <?php if($this->isRoute("carros.index") || $this->isRoute("carros.kits")): ?>
        <div>
          <label
          for="new-dispositivo-cantidad"
          class="form-label m-0 small">Cantidad:</label>
          <input
          id="new-dispositivo-cantidad"
          x-model.number="state.cantidad"
          type="number"
          min="0"
          required
          class="form-control form-control-sm">
        </div>
      <?php endif ?>

      <div>
        <label
        for="new-dispositivo-riesgo"
        class="form-label m-0 small">Riesgo:</label>
        <input
        id="new-dispositivo-riesgo"
        x-model.number="state.riesgo"
        type="text"
        required
        class="form-control form-control-sm">
      </div>

      <?= $this->fetch("./carro/historico/select-motivos.php") ?>
    </form>

    <div class="d-flex justify-content-between border-top p-2">
      <button
      @click="close"
      type="button"
      tabindex="-1"
      class="btn btn-sm btn-dark">Cancelar</button>

      <?php if($this->can("dispositivos.delete")): ?>
          <button
                  tabindex="-1"
                  x-show="isEdit"
                  @click="delDisp"
                  x-data="deleteDispositivo"
                  class="btn btn-sm btn-danger flex items-center gap-2"
          >
              <?= $this->fetch("./icons/trash.php") ?>
              <span>Eliminar</span>
          </button>
      <?php endif ?>

      <button
      form="create-dispositivo"
      type="submit"
      class="btn btn-sm btn-success">Guardar</button>
    </div>
  </div>
</div>
