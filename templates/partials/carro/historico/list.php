<div class="p-2 m-3 border rounded shadow">
  <h5 x-text="fecha" class="border-bottom"></h5>

  <ul class="list-group list-group-flush">
    <template x-for="r in data[fecha]" :key="r.id">
      <li class="list-group-item small">
        <span :class="{
          'text-bg-success': r.action == 'INSERT',
          'text-bg-warning': r.action == 'UPDATE',
          'text-bg-danger':  r.action == 'DELETE'
        }"
        x-text="r.hora"
        class="text-muted text-sm badge bg-opacity-25"></span>
        <span x-html="getRowText(r)"></span>
      </li>
    </template>
  </ul>
</div>
