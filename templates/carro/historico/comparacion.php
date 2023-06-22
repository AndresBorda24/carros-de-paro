<div x-data="historicoChanges" x-bind="events">
  <template x-if="Boolean(changes)">
    <div class="mt-2">
      <div class="text-center small border-top border-bottom p-1">
        <p class="m-0">
          Realizado por:
          <span
          class="fw-bold"
          x-text="changes.usuario"></span>
        </p>
        <p class="">
          El <span
          class="badge text-bg-dark"
          x-text="changes.fecha"></span> a las <span
          class="badge text-bg-dark"
          x-text="changes.hora"></span>
        </p>
        <p class="m-0">
          Motivo: <span
          class="badge text-bg-dark"
          x-text="changes.motivo">
        </p>
      </div>


      <div class="d-md-grid" style="grid-template-columns: 1fr auto 1fr;">
        <!-- Listado de cambios (antes) -->
        <div class="p-3 small">
          <?= $this->fetch('./carro/historico/before.php') ?>
        </div>

        <!-- Este es el divisor  -->
        <div class="border-end border-top border-secondary"></div>

        <!-- Listado de cambios (despues) -->
        <div class="p-3 small">
          <?= $this->fetch('./carro/historico/after.php') ?>
        </div>
      </div>
    </div>
  </template>
</div>
