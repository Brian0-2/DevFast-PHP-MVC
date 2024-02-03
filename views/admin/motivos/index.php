<h3 class="text-center"><?php echo $titulo; ?></h3>
<div class="dashboard__contenedor--boton">
    <a class="dashboard__boton" href="/admin/motivos/crear">
        <i class="fa-solid fa-circle-plus"></i></i>
        Nuevo Motivo Dev
    </a>
</div>

<?php include_once __DIR__ . '/../../templates/filtro.php'; ?>


<div class="dashboard__contenedor">
    <?php require_once __DIR__ . '/../../templates/alertas.php'; ?>

    <?php if (!empty($motivos)) { ?>
        <table class="table">
            <thead class="table__thead">
                <tr>
                    <th scope="col" class="table__th">Codigo</th>
                    <th scope="col" class="table__th">Nombre</th>
                    <th scope="col" class="table__th">Acciones</th>
                </tr>
            </thead>
            <tbody class="table_tbody">
                <?php foreach ($motivos as $motivo) { ?>
                    <tr class="table__tr">
                        <td class="table__td">
                            <?php echo $motivo->id; ?>
                        </td>
                        <td class="table__td">
                            <?php echo $motivo->motivo; ?>
                        </td>

                        <td class="table__td--acciones">
                            <a class="table__accion table__accion--editar" href="/admin/motivos/editar?id=<?php echo $motivo->id; ?>">
                                <i class="fa-solid fa-ruler"></i>
                                Editar
                            </a>
                            <button class="table__accion table__accion--eliminar" id="motivo" data-id="<?php echo $motivo->id; ?>">
                                <i class="fa-solid fa-trash"></i>
                                Eliminar
                            </button>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    <?php } else { ?>
        <p class="text-center">No hay Motivos...</p>
    <?php } ?>