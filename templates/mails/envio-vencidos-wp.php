*Medicamentos:*
<?php if(! empty($data["medicamentos"])): ?>
  <?php foreach($data["medicamentos"] as $med): ?>
  - _<?= $med["nombre"] ?>_ | <?= $med["vencimiento"] ?> | <?= $med["carro"] . "\n" ?>
  <?php endforeach ?>

<?php else: ?>
%2B -------------------------------------- %2B
|     No hay medicamentos por vencer       |
%2B -------------------------------------- %2B
<?php endif ?>

*Dispositivos:*
<?php if(! empty($data["dispositivos"])): ?>
  <?php foreach($data["dispositivos"] as $med): ?>
  - _<?= $med["nombre"] ?>_ | <?= $med["vencimiento"] ?> | <?= $med["carro"] . "\n" ?>
  <?php endforeach ?>

<?php else: ?>
%2B -------------------------------------- %2B
|     No hay dispositivos por vencer       |
%2B -------------------------------------- %2B
<?php endif ?>
