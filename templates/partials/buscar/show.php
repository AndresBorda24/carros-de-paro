<div
class="small table-responsive"
x-data="show"
x-cloak
x-show="historicoId">
  <template x-if="data">
  <table class="table table-sm w-100 table-bordered">
    <thead>
      <tr>
        <th>Nombre</th>
        <th>Invima</th>
        <th>Lote</th>
        <th>*</th>
      </tr>
    </thead>
    <tbody style="white-space: nowrap;">
      <template x-for="item in data.after" :key="item.id">
      <tr :class="isTheOne(item) ? 'table-dark' : ''">
        <td x-text="getItemName(item)"></td>
        <td x-text="item.invima"></td>
        <td x-text="item.lote"></td>
        <td>
          <details class="position-relative" @click.outside="$el.removeAttribute('open')">
            <summary class="list-unstyled" role="button">
              <?= $this->fetch("./icons/question.php") ?>
            </summary>
            <div class="list-group list-group-flush position-absolute top-0
            bg-body end-100 border rounded shadow" style="width: 150px;">
              <span class="list-group-item p-1">
                Cantidad: <span x-text="item.cantidad"></span>
              </span>
              <span class="list-group-item p-1">
                Fecha Vencimiento: <span x-text="item.vencimiento"></span>
              </span>
            </div>
          </details>
        </td>
      </tr>
      </template>
    </tbody>
  </table>
  </template>
</div>
