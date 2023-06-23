<div class="p-2 border rounded bg-body">
  <h5 x-data class="text-center">
    Registro de Aperturas para:
    <span
    class="text-bg-primary badge"
    x-text="getCarroNombre"></span>
  </h5>

  <?= $this->fetch("./carro/histo/select.php") ?>
  <?= $this->fetch("./carro/histo/show.php") ?>
</div>
