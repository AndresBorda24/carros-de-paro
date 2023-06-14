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
    <div class="w-100 p-2 p-md-3 mb-5">
      <h4>B&uacute;squeda</h4>
      <?= $this->fetch("./partials/buscar/formulario.php") ?>
      <?= $this->fetch("./partials/buscar/show-results.php") ?>
    </div>
  </main>
</body>
</html>
