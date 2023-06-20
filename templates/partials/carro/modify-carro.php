<details
x-data="modifyCarro('<?= $model ?>')"
class="position-relative">
  <summary
  class="btn btn-sm text-sm"
  :class="hasChanged ? 'btn-primary' : 'btn-outline-primary'"
  :style="!hasChanged && { borderStyle: 'dashed'}">
    <?= $this->fetch("./icons/check.php") ?>
    Registrar Revision
  </summary>

  <div
  style="min-width: 200px;"
  class="text-sm p-3 border shadow bg-body z-1 position-absolute top-100
  border-primary rounded mt-1 end-0">
    Por favor selecciona el motivo de la revisi&oacute;n
    <select class="form-select form-select-sm" x-model="motivo">
      <option value="" hidden selected> -- selecciona -- </option>
      <template x-for="motivo in motivos">
        <option :value="motivo" x-text="motivo"></option>
      </template>
    </select>
    <div class="mt-3 border-top pt-2">
      <button
      @click="save"
      class="btn btn-success btn-sm text-sm m-auto d-block"
      :disabled="cannotSave">
        Guardar!
      </button>
    </div>
  </div>
</details>
