<section
x-data="updateApertura"
x-show="carroStatus" x-cloak
class="position-relative"
@click.outside="close">
  <button
    @click="open"
    class="btn btn-sm btn-outline-success"
  >
    Guardar Revisi&oacute;n
  </button>

  <div
  x-show="show" x-transition
  class="position-absolute border bg-success-subtle z-1 top-100 p-2 small border-success rounded shadow mt-1 text-center"
  style="width: 380px; max-width: 80vw; right: -25%;">
    <form @submit.prevent="update">
      <label
      for="apertura-mensaje"
      class="fotm-label small text-muted">Mensaje(opcional):</label>
      <span class="small text-muted">
        ( <span
        :class="{ 'text-danger': messageLength > 300 }"
        x-text="messageLength"></span> / 300 )
      </span>
      <textarea
      id="apertura-mensaje"
      style="min-height: 150px; max-height: 220px;"
      x-model="message"
      class="form-control form-control-sm small"></textarea>

      <button
      type="submit"
      :disabled="(messageLength > 300)"
      class="btn btn-sm btn-success text-sm mt-2 d-block mx-auto">
        Guardar
        <?= $this->fetch("./icons/check.php") ?>
      </button>
    </form>
  </div>
</section>
