<button
x-data="print"
@click="__print"
class="btn btn-sm btn-dark text-sm flex items-center justify-center gap-1">
  Imprimir
    <span class="w-4 h-4 mt-0.5"><?= $this->fetch("./icons/print.php") ?></span>
</button>
