<template x-if="isEdit">
  <div>
    <label
    for="motivo-edicion"
    class="form-label small text-muted">Motivo Modificaci&oacute;n:</label>
    <select
    required
    x-model="state.motivo_edicion"
    id="motivo-edicion"
    class="form-control form-control-sm">
      <option value="" selected hidden>-- Motivo --</option>
      <option value="Motivo 1">Motivo 1</option>
      <option value="Motivo 2">Motivo 2</option>
      <option value="Motivo 3">Motivo 3</option>
    </select>
  </div>
</template>
