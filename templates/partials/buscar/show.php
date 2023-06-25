<div
class="small"
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
    <tbody>
      <template x-for="item in data.after" :key="item.id">
      <tr :class="isTheOne(item) ? 'table-dark' : ''">
        <td x-text="getItemName(item)"></td>
        <td x-text="item.invima"></td>
        <td x-text="item.lote"></td>
        <td>
          <?= $this->fetch("./icons/question.php") ?>
        </td>
      </tr>
      </template>
    </tbody>
  </table>
  </template>
</div>
