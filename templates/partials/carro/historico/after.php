<h6 class="text-center">Despu&eacute;s</h6>
<ul class="list-group">
  <template x-for="after in changes.after">
    <li
    :class="! parseInt(after.id) ?
      'list-group-item-success' :
      'list-group-item-primary'
    "
    class="list-group-item">
      <div class="w-100 d-flex gap-2 align-items-center">
        <span
        class="flex-grow-1"
        x-text="getItemNombre( after )"></span>
        <span
        x-text="after.cantidad"></span>

        <!-- Esto muestra unos detalles del item -->
        <details class="position-relative">
          <summary class="btn btn-sm p-0">
            <?= $this->fetch("./icons/question.php") ?>
          </summary>
          <div
          style="width: 150px;"
          class="bg-body p-1 border rounded shadow position-absolute end-100 top-0 z-1">
            Lote: <span x-text="after.lote"></span><br>
            Invima: <span x-text="after.invima"></span><br>
            Venc: <span x-text="after.vencimiento"></span>
          </div>
        </details>
      </div>

      <!-- Si se ha modificado, mostrara el motivo -->
      <template x-if="after.motivo_edicion">
        <span
        x-html="after.motivo_edicion"
        class="badge text-bg-light">
        </span>
      </template>
    </li>
  </template>
</ul>
