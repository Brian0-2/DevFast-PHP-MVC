<h3 class="text-center"> <?php echo $titulo; ?></h3>
<div class="contenedor-sm">
    <div class="dashboard__contenedor--boton">
            <a class="dashboard__boton" href="/admin/motivos">
                <i class="fa-solid fa-circle-arrow-left"></i></i>
                Volver
            </a>
        </div>

    <form class="formulario" method="POST">
       
    <?php require_once __DIR__ . '/../../templates/alertas.php'; ?>

        <label class="formulario__label" for="motivo">Nombre de la ruta?</label>
        <input class="formulario__input" type="text"
            name="motivo"
            id="motivo"
            placeholder="Ingresa el nuevo motivo..."
        />

        <input class="formulario__submit" type="submit" value="Crear">
    </form>
</div>