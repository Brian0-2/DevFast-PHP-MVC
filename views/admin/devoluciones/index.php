<h3 class="text-center"><?php echo $titulo; ?></h3>

<?php include_once __DIR__ . '/../../templates/filtro.php'; ?>

<ul class="listado-devs">
    <?php foreach ($rutas as $ruta) : ?>
        <a class="listado-devs__enlace" href="/admin/devoluciones/mostrar?id=<?php echo $ruta->id; ?>">
            <li  class="listado-devs__viaje"><?php echo $ruta->nombre; ?></li>
        </a>
    <?php endforeach; ?>
</ul>