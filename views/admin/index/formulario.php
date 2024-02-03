<form class="formulario contenedor-sm" method="POST" action="">
    <?php require_once __DIR__ . '/../../templates/alertas.php'; ?>

    <label class="formulario__label" for="viaje">Viaje</label>
    <select class="formulario__select" name="id_ruta" id="id_ruta">
        <option disabled selected value="">- Selecciona -</option>
        <!-- Mostrar la lista de viajes disponibles -->
        <?php if (empty($rutas)) { ?>
            <option class="formulario__option" disabled>Ya no hay rutas disponibles</option>
        <?php } else { ?>
            <?php foreach ($rutas as $ruta) { ?>
                <option class="formulario__option" value="<?php echo $ruta->id; ?>"><?php echo $ruta->nombre; ?></option>
            <?php } ?>
        <?php } ?>
    </select>

    <label class="formulario__label" for="id_usuario">Chofer</label>
    <select class="formulario__select" name="id_usuario" id="id_usuario">
        <option value="" selected disabled>- Selecciona -</option>
        <?php foreach($usuarios as $usuario){ ?>
            <option value="<?php echo $usuario -> id;  ?>"> <?php echo $usuario -> nombre; ?></option>
        <?php } ?>
    </select>

    <label class="formulario__label" for="cantidadfacturas">Cantidad de Facturas</label>
    <input class="formulario__input formulario__input--cantidadfacturas" type="number" name="cantidadfacturas" id="cantidadfacturas"
    value="<?php echo $viaje -> cantidadfacturas ?? ''; ?>" />

    <label class="formulario__label" for="clientesatendidos">Clientes Atendidos</label>
    <input class="formulario__input formulario__input--clientesatendidos" type="number" name="clientesatendidos" id="clientesatendidos" value="<?php echo $viaje -> clientesatendidos ?? ''; ?>" />
    <input class="formulario__submit" type="submit" value="Dar de alta">
</form>