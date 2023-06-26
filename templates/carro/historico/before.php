<h6 class="text-center">Antes</h6>
<ul class="list-group">
  <template x-for="b in before" :key="b.id">
    <li
    class="list-group-item d-flex gap-2 align-items-center px-1 py-0"
    :class="isDeleted(b.id)
      ? 'list-group-item-danger'
      : 'list-group-item-secondary'
    ">
      <span
      class="flex-grow-1"
      x-text="getItemNombre( b )"></span>
      <span
      x-text="b.cantidad"></span>

      <!-- Esto muestra unos detalles del item -->
      <details class="position-relative">
        <summary class="btn btn-sm p-0">
          <?= $this->fetch("./icons/question.php") ?>
        </summary>
        <div
        style="width: 200px;"
        class="bg-body p-1 border rounded shadow position-absolute end-100 top-0 z-1">
          Lote: <span x-text="b.lote"></span><br>
          Invima: <span x-text="b.invima"></span><br>
          Venc: <span x-text="b.vencimiento"></span>
        </div>
      </details>
    </li>
  </template>
</ul>
