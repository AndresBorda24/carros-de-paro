<div
class="p-3 d-flex flex-column gap-1"
x-data="histoShow"
x-bind="events">
  <template x-if="hasData">
    <div>
      <?= $this->fetch("./carro/histo/info.php") ?>
      <template x-for="i in [
        '<?= \App\Services\HistoricoService::MEDICAMENTO ?>',
        '<?= \App\Services\HistoricoService::DISPOSITIVO ?>'
      ]">
        <div x-data="histoComparacion(i)" class="small">
          <h5 class="text-center" x-text="i +'s'"></h5>
          <?= $this->fetch("./carro/histo/comparacion.php") ?>
        </div>
      </template>
    </div>
  </template>
</div>
