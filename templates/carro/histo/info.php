<div class="text-center small border-top border-bottom p-1 mb-3">
  <p class="m-0">
    Realizado por:
    <span
    class="fw-bold"
    x-text="data.usuario"></span>
  </p>
  <p class="m-0">
    El <span
    class="badge text-bg-dark"
    x-text="data.fecha"></span> a las <span
    class="badge text-bg-dark"
    x-text="data.hora"></span>
  </p>
  <p class="">
    Motivo: <span
    class="badge text-bg-dark"
    x-text="data.motivo">
  </p>
  <?= $this->fetch("./partials/print.php") ?>
</div>
