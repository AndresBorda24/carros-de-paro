*Medicamentos:*
<?php if(! empty($data["medicamentos"])): ?>
  <?php foreach($data["medicamentos"] as $med): ?>
  - _<?= $med["nombre"] ?>_ | <?= $med["vencimiento"] ?> | <?= $med["carro"] . "\n" ?>
  <?php endforeach ?>

<?php else: ?>
+ -------------------------------------- +
|     No hay medicamentos por vencerse   |
+ -------------------------------------- +
<?php endif ?>

*Dispositivos:*
<?php if(! empty($data["dispositivos"])): ?>
  <?php foreach($data["dispositivos"] as $med): ?>
  - _<?= $med["nombre"] ?>_ | <?= $med["vencimiento"] ?> | <?= $med["carro"] . "\n" ?>
  <?php endforeach ?>

<?php else: ?>
+ -------------------------------------- +
|     No hay dispositivos por vencerse   |
+ -------------------------------------- +
<?php endif ?>
