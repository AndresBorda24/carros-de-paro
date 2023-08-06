<details
x-data="updateApertura"
x-cloak
x-show="carroStatus"
class="position-relative"
@click.outside="$el.removeAttribute('open')">
  <summary class="btn btn-sm btn-outline-success">
    Guardar Revisi&oacute;n
  </summary>

  <div
  class="position-absolute border bg-success-subtle z-1 top-100 end-0 p-2 small border-success rounded shadow mt-1 text-center"
  style="width: 180px;">
    Recuerda registrar <span class="fw-bold">TODOS</span> los cambios en
    <span class="fw-bold">Medicamentos</span> y
    <span class="fw-bold">Dispositivos</span>.
    Si ya lo hiciste, pulsa en:

    <button
    @click="update"
    class="btn btn-sm btn-success text-sm mt-2 d-block mx-auto">
      Guardar
      <?= $this->fetch("./icons/check.php") ?>
    </button>
  </div>
</details>
