<h3 class="text-center"><?php echo $titulo; ?></h3>
<div class="dashboard__contenedor--boton">
    <a class="dashboard__boton" href="/admin/usuarios/crear">
        <i class="fa-solid fa-circle-plus"></i></i>
        Nuevo Usuario
    </a>
</div>

<?php include_once __DIR__ . '/../../templates/filtro.php'; ?>

<div class="dashboard__contenedor">
    <?php require_once __DIR__ . '/../../templates/alertas.php'; ?>

    <?php if (!empty($usuarios)) { ?>
        <table class="table">
            <thead class="table__thead">
                <tr>
                    <th scope="col" class="table__th">Codigo</th>
                    <th scope="col" class="table__th">Nombre</th>
                    <th scope="col" class="table__th">Imagen</th>
                    <th scope="col" class="table__th">Tipo usuario</th>
                    <th scope="col" class="table__th">Acciones</th>
                </tr>
            </thead>
            <tbody class="table_tbody">
                <?php foreach ($usuarios as $usuario) { ?>
                    <tr class="table__tr">
                        <td class="table__td">
                            <?php echo $usuario->id; ?>
                        </td>
                        <td class="table__td">
                            <?php echo $usuario->nombre; ?>
                        </td>
                        <td class="table__td">
                            <?php if ($usuario->imagen) { ?>
                                <div class="formulario__imagen">
                                    <picture>
                                        <source srcset="<?php echo $_ENV['HOST'] . '/img/users/' . $usuario->imagen; ?>.webp" type="image/webp">
                                        <source srcset="<?php echo $_ENV['HOST'] . '/img/users/' . $usuario->imagen; ?>.png" type="image/png">
                                        <img class="table__imagen" loading="lazy" width="200" height="300" src="<?php echo $_ENV['HOST'] . '/img/users/' . $usuario->imagen; ?>.png" alt="Imagen Usuario">
                                    </picture>
                                </div>
                            <?php } else { ?>
                                <p>Sin Imagen...</p>
                            <?php } ?>
                        </td>
                        <td class="table__td">
                            <?php if ($usuario->tipousuario === '0') { ?>
                                <p>Chofer</p>
                            <?php }
                            if ($usuario->tipousuario === '2') { ?>
                                <p>Administrador</p>
                            <?php }
                            if ($usuario->tipousuario === '3') { ?>
                                <p>Encargado Almacen</p>
                            <?php } ?>
                        </td>
                        <td class="table__td--acciones">
                            <a class="table__accion table__accion--editar" href="/admin/usuarios/editar?id=<?php echo $usuario->id; ?>">
                                <i class="fa-solid fa-user"></i>
                                Editar
                            </a>
                            <button class="table__accion table__accion--eliminar" id="usuario" data-id="<?php echo $usuario->id; ?>">
                                <i class="fa-solid fa-trash"></i>
                                Eliminar
                            </button>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    <?php } else { ?>
        <p class="text-center">No hay Usaurios...</p>
    <?php } ?>