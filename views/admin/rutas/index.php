<h3 class="text-center"><?php echo $titulo; ?></h3>
<div class="dashboard__contenedor--boton">
    <a class="dashboard__boton" href="/admin/rutas/crear">
        <i class="fa-solid fa-circle-plus"></i></i>
        Crear Nueva Ruta
    </a>
</div>

<?php include_once __DIR__ . '/../../templates/filtro.php'; ?>


<div class="dashboard__contenedor">
    <?php require_once __DIR__ . '/../../templates/alertas.php'; ?>

    <?php if (!empty($rutas)) { ?>
        <table class="table">
            <thead class="table__thead">
                <tr>
                    <th scope="col" class="table__th">Codigo</th>
                    <th scope="col" class="table__th">Nombre</th>
                    <th scope="col" class="table__th">Acciones</th>
                </tr>
            </thead>
            <tbody class="table_tbody">
                <?php foreach ($rutas as $ruta) { ?>
                    <tr class="table__tr">
                        <td class="table__td">
                            <?php echo $ruta->id; ?>
                        </td>
                        <td class="table__td">
                            <?php echo $ruta->nombre; ?>
                        </td>

                        <td class="table__td--acciones">
                            <a class="table__accion table__accion--editar" href="/admin/rutas/editar?id=<?php echo $ruta->id; ?>">
                                <i class="fa-solid fa-pencil"></i>
                                Editar
                            </a>
                            <button class="table__accion table__accion--eliminar" id="ruta" data-id="<?php echo $ruta->id; ?>">
                                <i class="fa-solid fa-trash"></i>
                                Eliminar
                            </button>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    <?php } else { ?>
        <p class="text-center">No hay Rutas...</p>
    <?php } ?>