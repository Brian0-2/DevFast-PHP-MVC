<h3 class="text-center">
    <?php echo $titulo; ?>
</h3>
<div class="contenedor-m">
    <form class="formulario" method="POST" action="/admin/reportes">
        <div class="formulario__container">
            <div class="box1">
                <label class="formulario__label" for="mes-ini">Filtrar Fecha Inicial</label>
                <input class="formulario__input" name="mes-ini" type="date">
            </div>
            <div class="box2">
                <label class="formulario__label" for="mes-final">Filtrar Fecha final</label>
                <input class="formulario__input" name="mes-final" type="date">
            </div>
        </div>
        <label class="formulario__label" for="viaje">Filtrar por viaje:</label>
        <select class="formulario__select" name="viaje" id="reporte">
            <option class="formulario__option" disabled selected value="">- Selecciona -</option>
            <option class="formulario__option" value="0">- Todas -</option>
            <?php foreach ($rutas as $ruta) { ?>
                <option class="formulario__option" value="<?php echo $ruta->id; ?>">
                    <?php echo $ruta->nombre; ?>
                </option>
            <?php } ?>
        </select>
        <div class="formulario__container">
            <div class="formulario__c1">
                <dialog>si</dialog>
            </div>
        </div>

        <label class="formulario__label" for="chofer">Filtrar por Chofer</label>
        <select class="formulario__select" name="chofer" id="chofer">
            <option class="formulario__option" disabled selected value="">- Selecciona -</option>
            <option class="formulario__option" value="0">- Todos -</option>
            <?php foreach ($choferes as $chofer) { ?>
                <option class="formulario__option" value="<?php echo $chofer->id; ?>">
                    <?php echo $chofer->nombre; ?>
                </option>
            <?php } ?>
        </select>

        <label class="formulario__label" for="motivo-dev">Filtrar por Motivo Devolucion</label>
        <select class="formulario__select" name="motivo-dev" id="motivo-dev">
            <option class="formulario__option" disabled selected value="">- Selecciona -</option>
            <option class="formulario__option" value="0">- Todos -</option>
            <?php foreach ($motivos as $motivo) { ?>
                <option class="formulario__option" value="<?php echo $motivo->id; ?>">
                    <?php echo $motivo->motivo; ?>
                </option>
            <?php } ?>
        </select>

        <label class="formulario__label" for="almacen">Filtrar por Almacen</label>
        <select class="formulario__select" name="almacen" id="almacen">
            <option class="formulario__option" disabled selected value="">- Selecciona -</option>
            <option class="formulario__option" value="0">- Todos -</option>
            <?php foreach ($almacenes as $almacen) { ?>
                <option class="formulario__option" value="<?php echo $almacen->id; ?>">
                    <?php echo $almacen->nombre; ?>
                </option>
            <?php } ?>
        </select>
        <input class="formulario__submit" type="submit" value="Enviar">
    </form>
</div>