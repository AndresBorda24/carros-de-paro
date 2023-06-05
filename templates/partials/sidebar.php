<div class="position-sticky top-0 p-3">
  <nav class="d-flex flex-column gap-1 mb-3">
    <a href="#" class="rounded-1 active btn btn-sm carro-nav-item">
      <?= $this->fetch("./icons/bookmark.php") ?>
      Carro
    </a>
    <a href="#" class="rounded-1 btn btn-sm carro-nav-item">
      <?= $this->fetch("./icons/bookmark.php") ?>
      Carro
    </a>
    <a href="#" class="rounded-1 btn btn-sm carro-nav-item">
      <?= $this->fetch("./icons/bookmark.php") ?>
      Carro
    </a>
    <a href="#" class="rounded-1 btn btn-sm carro-nav-item">
      <?= $this->fetch("./icons/bookmark.php") ?>
      Carro
    </a>
  </nav>

  <button
  x-data
  @click="$dispatch('create-carro')"
  style="font-size: .7rem;"
  class="btn btn-outline-success btn-sm text-end ms-auto d-block">
    <?= $this->fetch("./icons/plus.php") ?>
    Nuevo Carro
  </button>
</div>
