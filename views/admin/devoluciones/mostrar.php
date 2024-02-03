<h3 class="text-center">
    <?php echo $titulo; ?>
    </h1>
    <div class="dashboard__contenedor--boton">
        <a class="dashboard__boton" href="/admin/devoluciones">
            <i class="fa-solid fa-circle-arrow-left"></i></i>
            Volver
        </a>
    </div>
    <div class="filtro">
        <form class="filtro__formulario" method="POST" action="">
            <label class="filtro__label" for="fecha"> Filtrar:</label>
            <input class="filtro__input-fecha" type="date" id="fecha" max="<?php echo date('Y-m-d'); ?>" name="fecha" />
            <input class="filtro__boton" type="submit" value="Buscar">
        </form>
    </div>
    <p class="dashboard__contenedor--fecha">Fecha:
        <?php echo date("d/m/Y", strtotime($fecha)); ?>
    </p>
    <div class="dashboard__contenedor dashboard__contenedor--devs">
        <?php require_once __DIR__ . '/../../templates/alertas.php'; ?>

        <?php if (!empty($almacenes['almacen_1'])) { ?>
            <table class="table">
                <thead class="table__thead">
                    <tr>
                        <?php include __DIR__ . '/headers.php'; ?>
                        <th scope="col" class="table__th">Taka</th>
                        <th scope="col" class="table__th">Acciones</th>
                    </tr>
                </thead>
                <h3>Almacen 1</h3>
                <tbody class="table_tbody">
                    <?php foreach ($almacenes['almacen_1'] as $almacen) { ?>
                        <?php include __DIR__ . '../../../templates/admin-almacen.php'; ?>
                    <?php } ?>
                </tbody>
            </table>
        <?php } ?>


        <?php if (!empty($almacenes['almacen_2'])) { ?>
            <table class="table">
                <thead class="table__thead">
                    <tr>
                        <?php include __DIR__ . '/headers.php'; ?>
                        <th scope="col" class="table__th">Calero</th>
                        <th scope="col" class="table__th">Acciones</th>
                    </tr>
                </thead>
                <h3>Almacen 2</h3>
                <tbody class="table_tbody">
                    <?php foreach ($almacenes['almacen_2'] as $almacen) { ?>
                        <?php include __DIR__ . '../../../templates/admin-almacen.php'; ?>
                    <?php } ?>
                </tbody>
            </table>
        <?php } ?>



        <?php if (!empty($almacenes['almacen_4'])) { ?>
            <table class="table">
                <thead class="table__thead">
                    <tr>
                        <?php include __DIR__ . '/headers.php'; ?>
                        <th scope="col" class="table__th">Calero</th>
                        <th scope="col" class="table__th">Acciones</th>
                    </tr>
                </thead>
                <h3>Almacen 4</h3>
                <tbody class="table_tbody">
                    <?php foreach ($almacenes['almacen_4'] as $almacen) { ?>
                        <?php include __DIR__ . '../../../templates/admin-almacen.php'; ?>
                    <?php } ?>
                </tbody>
            </table>
        <?php } ?>

        <?php if (!empty($almacenes['almacen_3'])) { ?>
            <table class="table">
                <thead class="table__thead">
                    <tr>
                        <?php include __DIR__ . '/headers.php'; ?>
                        <th scope="col" class="table__th">Acciones</th>
                    </tr>
                </thead>
                <h3>Almacen 3</h3>
                <tbody class="table_tbody">
                    <?php foreach ($almacenes['almacen_3'] as $almacen) { ?>
                        <?php include __DIR__ . '../../../templates/admin-almacen.php'; ?>
                    <?php } ?>
                </tbody>
            </table>
        <?php } ?>
    </div>
