<div x-data="fieldsOrder('#<?= $listId ?>')">
  <textarea
    x-model="text"
    name="excel-text-<?= $listId ?>"
    class="form-control form-control-sm mb-3"></textarea>

  <button
    type="button"
    @click="showItemList = true"
    class="btn btn-sm btn-warning"
  >Ordenar Campos</button>
  <div
    x-transition
    x-show="showItemList"
    class="position-absolute p-2 top-0 start-0 w-100 h-100 bg-body-tertiary"
  >
    <button
      type="button"
      @click="showItemList = false"
      class="btn btn-sm btn-warning d-block mb-3"
    ><- Volver</button>

    <p class="text-center fw-semibold">Listado de campos, ordenamos arrastrando.</p>

    <ul class="list-group small" x-ignore  id="<?= $listId ?>">
      <?php foreach($items as $key => $value): ?>
        <li
          item-key="<?= $key ?>"
          class="list-group-item small"
        ><?= $value ?></li>
      <?php endforeach ?>
    </ul>
  </div>
</div>
