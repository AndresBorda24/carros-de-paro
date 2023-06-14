<template x-if="isCreated">
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
      <option value="Aver&amp;iacute;a">Aver&iacute;a</option>
      <option value="Proximo a vencer">Proximo a vencer</option>
      <option value="Gasto Paciente">Gasto Paciente</option>
    </select>
  </div>
</template>
