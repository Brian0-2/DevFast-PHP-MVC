<h3 class="text-center"> <?php echo $titulo; ?> </h3>

<div class="contenedor-sm">
    
<div class="dashboard__contenedor--boton">
        <a class="dashboard__boton" href="/admin/rutas">
            <i class="fa-solid fa-circle-arrow-left"></i></i>
            Volver
        </a>
    </div>
    <form class="formulario" method="POST">
        <?php require_once __DIR__ .'/../../templates/alertas.php'; ?>
        <label class="formulario__label" for="nombre">Edita Ruta</label>
            <input
            class="formulario__input"
                type="text"
                name="nombre"
                id="nombre"
                placeholder="Es necesario no dejar vacio el nombre"
                value="<?php echo $ruta -> nombre; ?>"
            />
            <input type="hidden" name="id" value="<?php echo $ruta -> id; ?>">

            <input class="formulario__submit" type="submit" value="Guardar Cambios">
    </form>
</div>