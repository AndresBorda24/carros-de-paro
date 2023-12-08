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
  <?= $this->loadAssets("print/app") ?>
  <style type="text/css">
    @media print {
      .pagebreak { page-break-before: always; } /* page-break-after works, as well */
    }
  </style>
  <title>Impresión General</title>
</head>
<body class="bg-white">
  <?php foreach($aperturas as $apertura): ?>
    <table class="table table-borderless table-sm pagebreak">
      <?= $this->fetch("./print/partials/header.php", [
        "_data" => [
          "tipo" => $apertura["tipo"],
          "fecha" => $apertura["fecha"],
          "usuario" => $apertura["usuario"],
          "carro_nombre" => $apertura["carro_nombre"],
          "carro_ubicacion" => $apertura["carro_ubicacion"],
        ]
      ]) ?>

      <tbody>
        <tr>
          <td>
            <?= $this->fetch("./print/partials/medicamentos.php", [
              "med" => $apertura[\App\Services\HistoricoService::MEDICAMENTO]
            ]) ?>
          </td>
        </tr>

        <tr>
          <td>
            <?= $this->fetch("./print/partials/dispositivos.php", [
              "dis" => $apertura[\App\Services\HistoricoService::DISPOSITIVO]
            ]) ?>
          </td>
        </tr>
      </tbody>

      <?= $this->fetch("./print/partials/footer.php", [
        "_data" => [
          "fecha" => $apertura["fecha"],
          "isCurrent" => false
        ]
      ]) ?>
    </table>
  <?php endforeach ?>
</body>
</html>
