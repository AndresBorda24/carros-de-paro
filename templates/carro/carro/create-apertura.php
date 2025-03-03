<div x-data="createApertura" class="d-flex align-items-center gap-1" x-bind="events">
  <details
  class="position-relative"
  @click.outside="$el.removeAttribute('open')">
    <summary class="btn btn-sm">
      <span class="text-sm text-danger" x-cloak x-show="! carroStatus">
        <?= $this->fetch("./icons/lock.php") ?>
      </span>
      <span class="text-sm text-danger" x-cloak x-show="carroStatus">
        <?= $this->fetch("./icons/unlock.php") ?>
      </span>
    </summary>

    <div class="position-absolute p-3 border-danger border bg-white rounded
    top-100 end-0 shadow z-1">
      <template x-if="carroStatus">
        <p class="small m-0" style="width: 150px;">
          Realiza todoas las modificaciones necesarias y luego da click en: <br>
          <span class="text-success border border-success badge">
          Guardar Revisi&oacute;n</span>
        </p>
      </template>
      <template x-if="! carroStatus">
        <div class="text-center">
          <select x-model="motivo" class="form-select form-select-sm mb-3 w-auto">
            <option value="" hidden selected>Selecciona Motivo</option>
            <?php if ($this->isRoute("carros.estantes")): ?>
              <option value="Actualizaci&oacute;n">Actualizaci&oacute;n</option>
              <option value="Revisi&oacute;n Mensual">Revisi&oacute;n Mensual</option>
              <option value="Auditor&iacute;a">Auditor&iacute;a</option>
              <?php elseif ($this->isRoute("carros.kits")): ?>
                  <option value="Actualizaci&oacute;n">Actualizaci&oacute;n</option>
                  <option value="Revisi&oacute;n Mensual">Revisi&oacute;n Mensual</option>
                  <option value="Auditor&iacute;a">Auditor&iacute;a</option>
            <?php elseif ($this->isRoute("carros.index")): ?>
              <option value="Auditor&iacute;a Interna">Auditor&iacute;a Interna</option>
              <option value="Auditor&Iacute;a Externa">Auditor&Iacute;a Externa</option>
              <option value="C&oacute;digo Azul">C&oacute;digo Azul</option>
              <option value="Mantenimiento">Mantenimiento</option>
              <option value="Revisi&oacute;n Mensual">Revisi&oacute;n Mensual</option>
            <?php endif ?>
          </select>

          <button
          class="btn btn-outline-success btn-sm"
          :disabled="! canOpenCarro"
          @click="saveApertura">
            <span class="text-sm">Abrir <?= $this->isRoute("carros.index")
              ? "Carro"
              : "Estante" ?>!</span>
          </button>
        </div>
      </template>
    </div>
  </details>

  <?= $this->fetch("./carro/carro/update-apertura.php") ?>
</div>
