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
  <?= $this->loadAssets("buscar/app") ?>
  <title>Buscar Hist&oacute;rico</title>
</head>
<body class="bg-body-tertiary">
  <?= $this->fetch("./partials/header.php") ?>
  <main class="container g-0">
    <div class="p-2 mt-3 sticky-top bg-body-tertiary border-bottom">
      <h4>B&uacute;squeda</h4>
      <?= $this->fetch("./partials/buscar/formulario.php") ?>
    </div>
    <div class="w-100 mb-4">
      <div class="rounded bg-white mt-3">
        <?= $this->fetch("./partials/buscar/select-results.php") ?>
      </div>
    </div>
  </main>

  <?= $this->fetch("./partials/loader.php") ?>
</body>
</html>
