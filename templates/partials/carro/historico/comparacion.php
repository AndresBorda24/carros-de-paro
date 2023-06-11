<template x-if="Boolean(changes)">
  <div class="d-md-grid" style="grid-template-columns: 1fr auto 1fr;">
    <div class="p-3">
      <h6 class="text-center">Antes</h6>
      <ul class="list-group text-sm">
        <template x-for="before in changes.before">
          <li class="list-group-item list-group-item-light d-flex gap-2 align-items-center">
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
    </div>

    <!-- Este es el divisor  -->
    <div class="border-end border-top"></div>

    <div class="p-3">
      <h6 class="text-center">Despu&eacute;s</h6>
      <ul class="list-group text-sm">
        <template x-for="after in changes.after">
          <li class="list-group-item list-group-item-primary">
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
              x-text="after.motivo_edicion"
              class="badge text-bg-light">
              </span>
            </template>
          </li>
        </template>
      </ul>
    </div>
  </div>
</template>
