<?php include_once __DIR__ . '/../../templates/admin-header.php'; ?>
<h3 class="text-center"><?php echo $titulo; ?></h3>
<div <?php aos_animation(); ?> class="chofer">
    <a class="chofer__boton" href="/choferes/index">
        <i class="fa-solid fa-circle-arrow-left"></i></i>
        Volver
    </a>
</div>
<main class="pendientes">
    <form method="POST" class="filtro" action="">
        <input class="filtro__input-fecha" 
               type="date" id="fecha" 
               max="<?php echo date('Y-m-d'); ?>" 
               name="fecha" />
        <input class="filtro__boton" 
               type="submit" 
               value="Buscar">
    </form>
    <div class="pendientes__listado slider swiper">
        <p class="dashboard__contenedor--fecha">Fecha: <?php echo date("d/m/Y", strtotime($fecha)); ?></p>
        <div class="pendientes__listado__data swiper-wrapper">
            <?php if (!empty($devoluciones)) { ?>
                <?php foreach ($devoluciones as $devolucion) { ?>
                    <div class="boleta swiper-slide">
                        <div class="boleta__header">
                            <p class="boleta__header">Num Dev# <span> <?php echo $devolucion->id; ?> </span></p>
                            <p class="boleta__header">fecha: <span><?php echo $devolucion->fecha; ?></span></p>
                        </div>
                        <div class="boleta__informacion">
                            <fieldset class="boleta__fieldset">
                                <legend class="boleta__legend">Detalle Cliente</legend>
                                <div class="boleta__clientes">
                                    <p class="boleta__cliente">Folio: <span><?php echo $devolucion->folio_cliente; ?></span></p>
                                    <p class="boleta__cliente">Nombre: <span><?php echo $devolucion->cliente; ?></span></p>
                                </div>
                            </fieldset>
                            <fieldset class="boleta__fieldset">
                                <legend class="boleta__legend">Detalle Material</legend>
                                <div class="boleta__folio">
                                    <p class="boleta__folio">Folio: <span><?php echo $devolucion->folio_material; ?></span></p>
                                    <p class="boleta__folio">Alamcen: <span><?php echo $devolucion->almacen; ?></span></p>
                                    <p class="boleta__folio">Factura: <span><?php echo $devolucion->factura; ?></span></p>
                                </div>
                                <p class="boleta__informacion">Material: <span><?php echo $devolucion->material; ?></span></p>
                                <div class="boleta__totales">
                                    <p class="boleta__informacion">Piezas: <span><?php echo $devolucion->piezas; ?></span></p>
                                    <p class="boleta__informacion">Precio: <span><?php echo "$" . $devolucion->precio; ?></span></p>
                                    <p class="boleta__informacion">Total: <span><?php echo "$" . $devolucion->total; ?></span></p>
                                </div>
                            </fieldset>
                            <p class="boleta__informacion">Motivo: <span><?php echo $devolucion->motivo; ?></span></p>
                            <p class="boleta__informacion">Detalle del Motivo: <span><?php echo $devolucion->descripcion; ?></span></p>
                            <div class="boleta__estados">
                                <p class="boleta__estado">Calero: <span><?php echo ($devolucion->calero === '0') ? 'Pendiente' : 'Revisado'; ?></span></p>
                                <p class="boleta__estado">Macario: <span><?php echo ($devolucion->macario === '0') ? 'Pendiente' : 'Revisado'; ?></span></p>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            <?php } else { ?>
                <p>No hay devolucines....</p>
            <?php } ?>
        </div>
        <div class="pendientes__right swiper-button-next"></div>
        <div class="pendientes__left swiper-button-prev"></div>
    </div>
</main>