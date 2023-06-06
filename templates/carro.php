<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link
  href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
  rel="stylesheet"
  integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM"
  crossorigin="anonymous">
  <?= $this->loadAssets("carro/app") ?>
  <title>Carros de Paro</title>
</head>
<body class="bg-body">
  <?= $this->fetch("./partials/header.php") ?>
  <main class="d-lg-flex container g-0">
    <div class="col-lg-3">
      <?= $this->fetch("./partials/sidebar.php") ?>
    </div>

    <div class="col-lg-9">
      <?= $this->fetch("./partials/carro/carro.php") ?>
    </div>
  </main>

  <!-- Modals -->
  <?= $this->fetch("./partials/carro/create-carro.php") ?>
</body>
</html>
