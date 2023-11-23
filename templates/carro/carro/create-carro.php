<div
x-data="createCarro"
x-bind="events"
x-show="show"
x-cloak
class="fixed-top vw-100 vh-100 bg-black bg-opacity-75">
  <div
  style="width: 80%; max-width: 300px;"
  class="mt-4 mx-2 p-2 bg-body mx-auto rounded-1">
    <h5 class="border-bottom text-center">Carro</h5>
    <form @submit.prevent="guardar" class="small" autocomplete="off">
      <label
      for="new-carro-nombre"
      class="form-label small text-muted">Nombre:</label>
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
      class="form-label small text-muted">Ubicaci&oacute;n:</label>
      <input
      id="new-carro-ubicacion"
      x-model="state.ubicacion"
      type="text"
      minlength="5"
      required
      class="form-control mb-3 form-control-sm">

      <div class="mb-3">
        <span>Tipo de Carro</span>

        <?php foreach(\App\Enums\CarroTipo::toArray() as $tipo => $val): ?>
        <div class="form-check">
          <input
            class="form-check-input"
            type="radio"
            required
            x-model="state.tipo"
            name="carro-tipo"
            value="<?= $val ?>"
            id="carro-tipo-<?=$tipo?>"
          >
          <label class="form-check-label" for="carro-tipo-<?=$tipo?>">
            <?= $tipo ?>
          </label>
        </div>
        <?php endforeach ?>
      </div>

      <div class="d-flex justify-content-between">
        <button
        @click="close"
        type="button"
        class="btn btn-sm text-sm btn-danger">Cancelar</button>
        <button
        type="submit"
        class="btn btn-sm text-sm btn-success">Guardar</button>
      </div>
    </form>
  </div>
</div>
