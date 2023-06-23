<div
class="d-md-grid border rounded mb-3 bg-body-tertiary"
style="grid-template-columns: 1fr auto 1fr;">
  <!-- Listado de cambios (antes) -->
  <div class="p-3 small">
    <?= $this->fetch('./carro/historico/before.php') ?>
  </div>

  <!-- Este es el divisor  -->
  <div class="border-end border-top"></div>

  <!-- Listado de cambios (despues) -->
  <div class="p-3 small">
    <?= $this->fetch('./carro/historico/after.php') ?>
  </div>
</div>
