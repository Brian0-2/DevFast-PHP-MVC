<?php include_once __DIR__ . '/../../templates/admin-header.php'; ?>
<div class="contenedor">
        <section class="principal">
                <h3 class="principal__titulo"><?php echo $titulo; ?></h3>
                <div class="principal__grid">
                        <?php if ($viaje) { ?>
                                <a <?php aos_animation(); ?> class="principal__enlace" href="/choferes/index/formulario">Hacer Devolucion?
                                        <i class="fa-regular fa-pen-to-square principal__icono"></i>
                                </a>
                        <?php } else { ?>
                                <div class="principal__no-viaje">
                                        <p class="principal__no-viaje-texto">Viaje no dado de alta...</p>
                                        <i class="fa-regular fa-circle-xmark  principal__no-viaje-icono"></i>
                                </div>
                        <?php } ?>
                                <a <?php aos_animation(); ?> class="principal__enlace" href="/choferes/index/devoluciones">Revisar Devoluciones?
                                        <i class="fa-solid fa-magnifying-glass principal__icono"></i>
                                </a>
                </div>
        </section>
</div>