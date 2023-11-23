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

  <template x-if="data.mensaje">
    <section class="small text-muted border rounded m-3 shadow-sm">
      <span class="fw-bold">Mensaje:</span>
      <p x-text="data?.mensaje"></p>
    </section>
  </template>
  <?= $this->fetch("./partials/print.php") ?>
</div>
