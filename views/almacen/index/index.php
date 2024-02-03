<?php include_once __DIR__ . '/../../templates/admin-header.php'; ?>

<main class="agenda">
<form method="POST" class="filtro" action="">
        <input class="filtro__input-fecha" 
               type="date" id="fecha" 
               max="<?php echo date('Y-m-d'); ?>" 
               name="fecha" />
        <input class="filtro__boton" 
               type="submit" 
               value="Buscar">
    </form>
    <?php if ($_SESSION['id_almacen'] === '2') { ?>
        <div class="agenda__almacenes slider swiper">
            <h4 class="agenda__almacen">Almacen 2</h4>
            <div class="swiper-pagination">Pagina</div> <!-- Paginación -->
            <div class="slider-count"></div> <!-- Contador de sliders -->
            <p class="dashboard__contenedor--fecha">Fecha: <?php echo date("d/m/Y", strtotime($fecha)); ?></p>

            <?php if (!empty($almacenes['almacen_2'])) { ?>
                <div class="swiper-wrapper">
                    <?php foreach ($almacenes['almacen_2'] as $almacen) { ?>
                        <?php include __DIR__ . '../../../templates/almacen.php'; ?>
                    <?php } ?>
                </div>
                <div class="pendientes__right swiper-button-next"></div>
                <div class="pendientes__left swiper-button-prev"></div>
        </div>
    <?php } else { ?>
        <p>No hay devoluciónes.</p>
    <?php } ?>

    <div class="agenda__almacenes slider swiper">
        <h4 class="agenda__almacen">Almacen 4</h4>
        <div class="swiper-pagination">Pagina</div> <!-- Paginación -->
            <div class="slider-count"></div> <!-- Contador de sliders -->
            <p class="dashboard__contenedor--fecha">Fecha: <?php echo date("d/m/Y", strtotime($fecha)); ?></p>
        <?php if (!empty($almacenes['almacen_4'])) { ?>
            <div class="swiper-wrapper">
                <?php foreach ($almacenes['almacen_4'] as $almacen) { ?>
                    <?php include __DIR__ . '../../../templates/almacen.php'; ?>
                <?php } ?>
            </div>
            <div class="pendientes__right swiper-button-next"></div>
            <div class="pendientes__left swiper-button-prev"></div>
    </div>
<?php } else { ?>
    <p>No hay devoluciónes.</p>
<?php } ?>
<?php } ?>

<?php if ($_SESSION['id_almacen'] === '1') { ?>

    <div class="agenda__almacenes slider swiper">
        <h4 class="agenda__almacen">Almacen 1</h4>
        <div class="swiper-pagination">Pagina</div> <!-- Paginación -->
            <div class="slider-count"></div> <!-- Contador de sliders -->
            <p class="dashboard__contenedor--fecha">Fecha: <?php echo date("d/m/Y", strtotime($fecha)); ?></p>
        <?php if (!empty($almacenes['almacen_1'])) { ?>

            <div class="swiper-wrapper">
                <?php foreach ($almacenes['almacen_1'] as $almacen) { ?>
                    <?php include __DIR__ . '../../../templates/almacen.php'; ?>
                <?php } ?>
            </div>
            <div class="pendientes__right swiper-button-next"></div>
            <div class="pendientes__left swiper-button-prev"></div>
    </div>
<?php } else { ?>
    <p>No hay devoluciones</p>
<?php } ?>

<?php } ?>

</main>