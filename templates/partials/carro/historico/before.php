<h6 class="text-center">Antes</h6>
<ul class="list-group text-sm">
  <template x-for="before in changes.before">
    <li class="list-group-item list-group-item-secondary d-flex gap-2 align-items-center">
      <span
      class="flex-grow-1"
      x-text="getItemNombre( before )"></span>
      <span
      x-text="before.cantidad"></span>

      <!-- Esto muestra unos detalles del item -->
      <details class="position-relative">
        <summary class="btn btn-sm p-0">
          <?= $this->fetch("./icons/question.php") ?>
        </summary>
        <div
        style="width: 150px;"
        class="bg-body p-1 border rounded shadow position-absolute end-100 top-0 z-1">
          Lote: <span x-text="before.lote"></span><br>
          Invima: <span x-text="before.invima"></span><br>
          Venc: <span x-text="before.vencimiento"></span>
        </div>
      </details>
    </li>
  </template>
</ul>
