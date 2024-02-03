<h3 class="text-center">
    <?php echo $titulo; ?>
</h3>
<div class="dashboard__contenedor--boton">
    <a class="dashboard__boton" href="/admin/usuarios">
        <i class="fa-solid fa-circle-arrow-left"></i></i>
        Volver
    </a>
</div>

<div class="contenedor-sm">
    <form class="formulario" method="POST" enctype="multipart/form-data">
        <?php require_once __DIR__ . '/../../templates/alertas.php'; ?>
        <label class="formulario__label" for="nombre">Nombre</label>
        <input class="formulario__input" 
               type="text" 
               name="nombre" 
               id="nombre" 
               placeholder="El nombre es obligatorio..."
               value="<?php echo $usuario->nombre; ?>" />
        <label class="formulario__label" for="tipousuario">Tipo de Usuario</label>
        <select class="formulario__select" name="tipousuario" id="tipousuario" />
            <option class="formulario__option" value="" selected disabled>- Selecciona -</option>
            <?php if($usuario -> tipousuario !== '3'){ ?>
                <option class="formulario__option" <?php echo ($usuario->tipousuario == 0) ? 'selected' : ''; ?> value="0">-
                    Chofer -
                </option>
                <option class="formulario__option" <?php echo ($usuario->tipousuario == 2) ? 'selected' : ''; ?> value="2">-
                    Administrador -
                </option>
            <?php } ?>
            <option class="formulario__option" <?php echo ($usuario->tipousuario == 3) ? 'selected' : ''; ?> value="3">-
                Encargado de Almacen -
            </option>
        </select>
        <?php if ($usuario->tipousuario == 3) { ?>
            <div class="formulario__option-almacen" id="option-almacen">

                <?php foreach ($almacenes as $almacen) { ?>
                    <div class="formulario__opciones">
                        <label class="formulario__label" for="">
                            <?php echo $almacen->nombre; ?>
                        </label>
                        <input class="formulario__radio" 
                               id="a<?php echo $almacen->id; ?>" 
                               value="<?php echo $almacen ->id; ?>" 
                               name="id_almacen"
                               type="radio"
                               <?php echo ($usuario -> id_almacen === $almacen -> id) ? 'checked' : ''; ?>
                        />
                    </div>
                <?php } ?>
            </div>
        <?php } ?>

        <div class="formulario__option-almacen" id="option-almacen">
        </div>
        <label class="formulario__label" for="imagen">Imagen</label>
        <input type="file" class="formulario__input formulario__input--file" id="imagen" name="imagen" />
        <?php if ($usuario->imagen) { ?>
            <p class="formulario__texto">Imagen Actual</p>
            <div class="formulario__imagen">
                <picture>
                    <source srcset="<?php echo $_ENV['HOST'] . '/img/users/' . $usuario->imagen; ?>.webp" type="image/webp">
                    <source srcset="<?php echo $_ENV['HOST'] . '/img/users/' . $usuario->imagen; ?>.avif" type="image/avif">
                    <source srcset="<?php echo $_ENV['HOST'] . '/img/users/' . $usuario->imagen; ?>.png" type="image/png">
                    <img src="<?php echo $_ENV['HOST'] . '/img/users/' . $usuario->imagen; ?>.png" alt="Imagen ponente">
                </picture>
            </div>
        <?php } else { ?>
            <p class="formulario__texto">Sin imagen...</p>
        <?php } ?>
        <label class="formulario__label" for="password">Contraseña actual</label>
        <input class="formulario__input" 
               type="password" 
               name="password" 
               id="password"
               placeholder="El password es obligatorio para cualquier edicion..." />
        <label class="formulario__label" for="password_new">Contraseña Nueva</label>
        <input class="formulario__input"
            type="password"
            name="password_new"
            id="password_new"
            placeholder="Contraseña nueva si se va a cambiar..."
        />
        <label class="formulario__label" for="password_repeat">Repetir contraseña</label>
        <input class="formulario__input"
            type="password"
            name="password_repeat"
            id="password_repeat"
            placeholder="Repite contraseña si colocaste una nueva..."
        />
        <input class="formulario__submit" type="submit" value="Editar Usuario">
    </form>
</div>