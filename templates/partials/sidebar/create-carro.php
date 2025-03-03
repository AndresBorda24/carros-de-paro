<button
        @click="$dispatch('create-carro')"
        style="font-size: .7rem;"
        class="btn btn-success btn-sm text-sm flex items-center gap-2"
>
  <span class="w-4 h-4 flex-shrink-0">
    <?= $this->fetch("./icons/plus.php") ?>
  </span>
    <span class="hidden md:inline">Nuevo Carro</span>
</button>
