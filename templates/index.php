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
  <?= $this->loadAssets("app") ?>
  <title>Hola Mundo</title>
</head>
<body class="bg-body">
  <?= $this->fetch("./partials/header.php") ?>
  <main class="d-grid container" style="grid-template-columns: 270px 1fr;">
    <div>
      <?= $this->fetch("./partials/sidebar.php") ?>
    </div>
    <div class="p-4">
      <h1 class="fs-4 text-center">Nombre del Carro</h1>
    </div>
  </main>
</body>
</html>
