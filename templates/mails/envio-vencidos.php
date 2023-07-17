<?php
    $tdStyle = "
      border-width: 2px;
      border-color: #7ea8f8;
      border-style: solid;
      padding: 5px;
    ";
    $tableStyle = "
      width: 100%;
      background-color: #FFFFFF;
      border-collapse: collapse;
      border-width: 2px;
      border-color: #7ea8f8;
      border-style: solid;
      color: #000000;
    ";
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Medicamentos & Dispositivos Proximos a Vencer</title>
</head>
<body>
    <h1 style="text-align: center;">Medicamentos & Dispositivos Proximos a Vencer</h1>
    <h3>Medicamentos: </h3>
    <?php if(! empty($data["medicamentos"])): ?>
        <table border="1"style="<?= $tableStyle ?>"cellpadding="3"cellspacing="3">
            <thead style="background-color: #7ea8f8;">
                <tr>
                    <th style="<?= $tdStyle ?>">Nombre</th>
                    <th style="<?= $tdStyle ?>">Fecha Vencimiento</th>
                    <th style="<?= $tdStyle ?>">Carro</th>
                    <th style="<?= $tdStyle ?>">Ubicaci&oacute;n</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($data["medicamentos"] as $med): ?>
                    <tr>
                        <td style="<?= $tdStyle ?>"><?= $med["nombre"] ?></td>
                        <td style="<?= $tdStyle ?>"><?= $med["vencimiento"] ?></td>
                        <td style="<?= $tdStyle ?>"><?= $med["carro"] ?></td>
                        <td style="<?= $tdStyle ?>"><?= $med["ubicacion"] ?></td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    <?php else: ?>
        <div style="padding: 10px; text-align: center; background-color: #7ea8f8; font-weight: bold; border-radius: 5px">
            <p>No hay medicamentos proximos a vencer!</p>
        </div>
    <?php endif ?>

    <h3>Dispositivos: </h3>
    <?php if(! empty($data["dispositivos"])): ?>
        <table border="1"style="<?= $tableStyle ?>"cellpadding="3"cellspacing="3">
            <thead style="background-color: #7ea8f8;">
                <tr>
                    <th style="<?= $tdStyle ?>">Nombre</th>
                    <th style="<?= $tdStyle ?>">Fecha Vencimiento</th>
                    <th style="<?= $tdStyle ?>">Carro</th>
                    <th style="<?= $tdStyle ?>">Ubicaci&oacute;n</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($data["dispositivos"] as $disp): ?>
                    <tr>
                        <td style="<?= $tdStyle ?>"><?= $disp["nombre"] ?></td>
                        <td style="<?= $tdStyle ?>"><?= $disp["vencimiento"] ?></td>
                        <td style="<?= $tdStyle ?>"><?= $disp["carro"] ?></td>
                        <td style="<?= $tdStyle ?>"><?= $disp["ubicacion"] ?></td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    <?php else: ?>
        <div style="padding: 10px; text-align: center; background-color: #7ea8f8; font-weight: bold; border-radius: 5px">
            <p>No hay dispositivos proximos a vencer!</p>
        </div>
    <?php endif ?>
</body>
</html>
