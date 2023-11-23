<div
x-data="createCarro"
x-bind="events"
x-show="show"
x-cloak
class="fixed-top vw-100 vh-100 bg-black bg-opacity-75">
  <div
  style="width: 80%; max-width: 300px;"
  class="mt-4 mx-2 bg-body mx-auto rounded-1 overflow-auto">
    <h5 class="border-bottom text-center m-0 p-2 fw-bold">Carro</h5>
    <form
      @submit.prevent="guardar"
      class="p-3 bg-body-tertiary"
      id="form-create-carro"
      autocomplete="off"
    >
      <label
      for="new-carro-nombre"
      class="form-label small ">Nombre:</label>
      <input
      id="new-carro-nombre"
      x-model="state.nombre"
      type="text"
      minlength="5"
      required
      autofocus
      class="form-control mb-3 form-control-sm">

      <label
      for="new-carro-ubicacion"
      class="form-label small ">Ubicaci&oacute;n:</label>
      <input
      id="new-carro-ubicacion"
      x-model="state.ubicacion"
      type="text"
      minlength="5"
      required
      class="form-control mb-3 form-control-sm">

      <div class="d-flex flex-wrap">
        <span class="form-label small w-100">Tipo de Carro:</span>

        <?php foreach(\App\Enums\CarroTipo::toArray() as $tipo => $val): ?>
        <div class="form-check flex-grow-1">
          <input
            class="form-check-input border-dark-subtle"
            type="radio"
            required
            x-model="state.tipo"
            name="carro-tipo"
            value="<?= $val ?>"
            id="carro-tipo-<?=$tipo?>"
          >
          <label role="button" class="form-check-label" for="carro-tipo-<?=$tipo?>">
            <?= $tipo ?>
          </label>
        </div>
        <?php endforeach ?>
      </div>
    </form>
    <div class="d-flex justify-content-between bg-body border-top p-2">
      <button
      @click="close"
      type="button"
      class="btn btn-sm btn-danger">Cancelar</button>
      <button
      type="submit"
      form="form-create-carro"
      class="btn btn-sm btn-success">Guardar</button>
    </div>
  </div>
</div>
