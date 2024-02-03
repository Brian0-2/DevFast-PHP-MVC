<?php
foreach ($alertas as $key => $alerta) {
    foreach ($alerta as $mensaje) {
?>
        <div <?php aos_animation(); ?> class="alerta alerta__<?php echo $key; ?>">

            <?php echo $mensaje; ?>

        </div>
<?php
    }
}
?>