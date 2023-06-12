<template x-if="Boolean(changes)">
  <div class="d-md-grid" style="grid-template-columns: 1fr auto 1fr;">
    <!-- Listado de cambios (antes) -->
    <div class="p-3">
      <?= $this->fetch('./partials/carro/historico/before.php') ?>
    </div>

    <!-- Este es el divisor  -->
    <div class="border-end border-top border-secondary"></div>

    <!-- Listado de cambios (despues) -->
    <div class="p-3">
      <?= $this->fetch('./partials/carro/historico/after.php') ?>
    </div>
  </div>
</template>
