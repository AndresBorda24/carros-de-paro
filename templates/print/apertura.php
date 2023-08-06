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
  <table class="table table-borderless table-sm">
    <thead>
      <tr>
        <th class=" d-flex align-items-center justify-content-between">
          <img
          height="35"
          src="<?= $this->asset("img/logo.png") ?>"
          alt="logo-asotrauma">
          <span class="badge text-bg-light rounded-1 fw-medium">
            <span >Carro de paro - </span> <?= $_data["carro_ubicacion"] ?? '' ?>
          </span>
        </th>
      </tr>
      <tr>
        <th class="small text-muted">
          <span class="small">
            Revisi&oacute;n <?= $_data["usuario"] ?> | <?= $_data["fecha"] ?>
          </span>
        </th>
      </tr>
    </thead>

    <tbody>
      <tr>
        <td>
          <table class="table table-sm mb-5 border small">
            <thead>
              <tr>
                <th colspan="8">
                  <span class="fw-bodl">Medicamentos</span>
                </th>
              </tr>
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
                    <?= $printDate($row->vencimiento) ?>
                  </td>
                  <td><?= $row->cantidad ?></td>
                </tr>
              <?php endforeach ?>
            </tbody>
          </table>
        </td>
      </tr>

      <tr>
        <td>
          <table class="table table-sm mb-5 border small">
            <thead>
              <tr>
                <th colspan="9">
                  <span class="fw-bodl">Dispositivos</span>
                </th>
              </tr>
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
                    <?= $printDate($row->vencimiento) ?>
                  </td>
                  <td><?= $row->cantidad ?></td>
                  <td><?= $row->vida_util ?></td>
                  <td><?= $row->riesgo ?></td>
                </tr>
              <?php endforeach ?>
            </tbody>
          </table>
        </td>
      </tr>
    </tbody>
  </table>
</body>
</html>
