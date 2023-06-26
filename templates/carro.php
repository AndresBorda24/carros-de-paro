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

  <link
  href="https://cdn.datatables.net/fixedcolumns/4.2.2/css/fixedColumns.dataTables.min.css"
  rel="stylesheet">
  <?= $this->loadAssets("carro/app") ?>
  <title>Carros de Paro</title>
</head>
<body class="bg-body-tertiary">
  <?= $this->fetch("./partials/header.php") ?>
  <main class="d-lg-flex container g-0">
    <div class="col-lg-3" style="max-width: 250px;">
      <?= $this->fetch("./partials/sidebar.php") ?>
    </div>

    <div class="col-lg-9 flex-grow-1">
      <?= $this->fetch("./carro/carro/carro.php") // xD ?>
    </div>
  </main>

  <!-- Modals -->
  <?php if ($this->can("carro.create") || $this->can('carro.edit')) {
    echo $this->fetch("./carro/carro/create-carro.php");
  }?>

  <?php if ($this->can("medicamentos.create") || $this->can('medicamentos.edit')) {
    echo $this->fetch("./carro/carro/create-medicamento.php");
  }?>

  <?php if ($this->can("dispositivos.create") || $this->can('dispositivos.edit')) {
    echo $this->fetch("./carro/carro/create-dispositivo.php") ;
  }?>

  <?= $this->fetch("./partials/loader.php") ?>
</body>
</html>
