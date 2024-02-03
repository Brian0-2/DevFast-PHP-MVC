<h3 class="text-center"> <?php echo $titulo; ?></h3>

<div class="contenedor-sm">
    <div class="dashboard__contenedor--boton">
        <a class="dashboard__boton" href="/admin/usuarios">
        <i class="fa-solid fa-circle-arrow-left"></i></i>
                Volver
        </a>
    </div>
    <form class="formulario" method="POST" enctype="multipart/form-data">
        <?php require_once __DIR__ .'/../../templates/alertas.php'; ?>
        <label class="formulario__label" for="nombre">Nombre</label>
        <input class="formulario__input"
            type="text"
            name="nombre"
            id="nombre"
            placeholder="El nombre es obligatorio..."
            value="<?php echo $usuario -> nombre; ?>"
        />
        <label class="formulario__label" for="tipousuario">Tipo de Usuario</label>
       <select class="formulario__select" 
               name="tipousuario" 
               id="tipousuario"
               />
            <option class="formulario__option" value="" selected disabled >- Selecciona -</option>
            <option class="formulario__option" value="0">- Chofer -</option>
            <option class="formulario__option" value="2">- Administrador -</option>
            <option class="formulario__option" value="3">- Encargado de Almacen -</option>
       </select>
       <div class="formulario__option-almacen" id="option-almacen">

       </div>
       <label class="formulario__label" for="imagen">Imagen</label>
        <input type="file"
               class="formulario__input formulario__input--file"
               id="imagen"
               name="imagen"
               accept="image/jpeg, image/png"
        />
        <label class="formulario__label" for="password">Password</label>
        <input class="formulario__input"
            type="password"
            name="password"
            id="password"
            placeholder="El password es obligatorio..."
        />
        <label class="formulario__label" for="password_repeat">Repetir Password</label>
        <input class="formulario__input"
            type="password"
            name="password_repeat"
            id="password_repeat"
            placeholder="Repite password"
        />
        <input class="formulario__submit" type="submit" value="Crear Usuario">
    </form>
</div>