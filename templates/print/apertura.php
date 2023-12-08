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
  <title>Revisi&oacute;n <?= $data["usuario"] ?> | <?= $data["fecha"] ?></title>
</head>
<body class="bg-white">
  <table class="table table-borderless table-sm">
    <?= $this->fetch("./print/partials/header.php", [
      "tipo" => $data["tipo"],
      "fecha" => $data["fecha"],
      "usuario" => $data["usuario"],
      "carro_nombre" => $data["carro_nombre"],
      "carro_ubicacion" => $data["carro_ubicacion"]
    ]) ?>

    <tbody>
      <tr>
        <td>
          <?= $this->fetch("./print/partials/medicamentos.php", [
            "printDate" => $printDate,
            "compDate" => $compDate, //Fecha con la que se compara la f de vencimiento
            "getDateColor" => $getDateColor,
            "med" => $data[\App\Services\HistoricoService::MEDICAMENTO]
          ]) ?>
        </td>
      </tr>

      <tr>
        <td>
          <?= $this->fetch("./print/partials/dispositivos.php", [
            "printDate" => $printDate,
            "compDate" => $compDate, //Fecha con la que se compara la f de vencimiento
            "getDateColor" => $getDateColor,
            "dis" => $data[\App\Services\HistoricoService::DISPOSITIVO],
          ]) ?>
        </td>
      </tr>
    </tbody>

    <?= $this->fetch("./print/partials/footer.php", [
      "compDate" => $compDate,
      "aperturaFecha" => $data["fecha"]
    ]) ?>
  </table>
</body>
</html>
