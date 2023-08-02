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
  <title>Revisi&oacute;n <?= $_data["usuario"] ?> | <?= $_data["fecha"] ?></title>
</head>
<body class="bg-white">
  <?= $this->fetch("./print/partials/header.php") ?>
  <div class="p-3 small">
    <h4>Medicamentos</h4>
    <table class="table table-sm mb-5 border small">
      <thead>
        <tr>
          <th>Principio Activo / Concentraci&oacute;n</th>
          <th>Forma Farmac&eacute;utica</th>
          <th>U / medida</th>
          <th>Presentaci&oacute;n</th>
          <th>Invima</th>
          <th>Lote</th>
          <th>Fecha Vencimiento</th>
          <th>Cantidad</th>
        </tr>
      </thead>
      <tbody class="small">
        <?php foreach($_data[\App\Services\HistoricoService::MEDICAMENTO]["after"] as $row): ?>
          <tr>
            <td><?= $row->p_activo_concentracion ?></td>
            <td><?= $row->forma_farma ?></td>
            <td><?= $row->medida ?></td>
            <td><?= $row->presentacion ?></td>
            <td><?= $row->invima ?></td>
            <td><?= $row->lote ?></td>
            <td class="<?= $dateColor($row->vencimiento) ?>">
              <?= $row->vencimiento ?>
            </td>
            <td><?= $row->cantidad ?></td>
          </tr>
        <?php endforeach ?>
      </tbody>
    </table>

    <h4>Dispositivos</h4>
    <table class="table table-sm mb-5 border small">
      <thead>
        <tr>
          <th>Descripci&oacute;n</th>
          <th>Marca</th>
          <th>Presentaci&oacute;n</th>
          <th>Invima</th>
          <th>Lote</th>
          <th>Fecha Vencimiento</th>
          <th>Cant.</th>
          <th>Vida &uacute;til</th>
          <th>Riesgo</th>
        </tr>
      </thead>
      <tbody class="small">
        <?php foreach($_data[\App\Services\HistoricoService::DISPOSITIVO]["after"] as $row): ?>
          <tr>
            <td><?= $row->desc ?></td>
            <td><?= $row->marca ?></td>
            <td><?= $row->presentacion ?></td>
            <td><?= $row->invima ?></td>
            <td><?= $row->lote ?></td>
            <td class="<?= $dateColor($row->vencimiento) ?>">
              <?= $row->vencimiento ?>
            </td>
            <td><?= $row->cantidad ?></td>
            <td><?= $row->vida_util ?></td>
            <td><?= $row->riesgo ?></td>
          </tr>
        <?php endforeach ?>
      </tbody>
    </table>
  </div>

  <div class="text-sm">
    Impresi&oacute;n Generada por:
    <span class="mx-2 fw-bold"><?= $user->getNombre() ?></span>
    el
    <span class="mx-2 fw-bold"><?= date("Y-m-d") ?></span>
  </div>

  <div class="text-center p-1 bg-blue-main small">
    <span class="small text-light">
        NIT: 800209891-7
    </span>
    <span class="mx-2 text-light">|</span>
    <span class="small text-light">
        Cra. 4D No. 32 - 34 , Ibagu&eacute;, Tolima
    </span>
  </div>
</body>
</html>
