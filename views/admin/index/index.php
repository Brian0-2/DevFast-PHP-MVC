<h3 class="text-center">
    <?php echo $titulo; ?>
</h3>
<div class="dashboard__contenedor--boton">
    <a class="dashboard__boton" href="/admin/index/crear?fecha=<?php echo date('Y-m-d'); ?>">
        <i class="fa-solid fa-circle-plus"></i></i>
        Dar de alta
    </a>
</div>

<div class="filtro">
    <form class="filtro__formulario" method="POST" action="">
        <label class="filtro__label" for="fecha"> Filtrar:</label>
        <input class="filtro__input-fecha" type="date" id="fecha" max="<?php echo date('Y-m-d'); ?>" name="fecha" />
        <input class="filtro__boton" type="submit" value="Buscar">
        <input class="filtro__input" type="filtro" name="filtro" id="filtro" placeholder="Click y buscar..." />
    </form>
</div>

<div class="dashboard__contenedor">
    <?php require_once __DIR__ . '/../../templates/alertas.php'; ?>

    <p class="dashboard__contenedor--fecha">Fecha:
        <?php echo date("d/m/Y", strtotime($viaje)); ?>
    </p>
    <?php if (!empty($viajes)) { ?>
        <table class="table">
            <thead class="table__thead">
                <tr>
                    <th scope="col" class="table__th">Folio</th>
                    <th scope="col" class="table__th">Viaje</th>
                    <th scope="col" class="table__th">Chofer</th>
                    <th scope="col" class="table__th">Cant Factuas</th>
                    <th scope="col" class="table__th">Clientes Atendidos</th>
                    <th scope="col" class="table__th">Horas de alta</th>
                    <th scope="col" class="table__th">Hora llegada</th>
                    <th scope="col" class="table__th">Acciones</th>
                </tr>
            </thead>
            <tbody class="table_tbody">
                <?php foreach ($viajes as $viaje) { ?>

                    <tr class="table__tr">
                        <td class="table__td">
                            <?php echo $viaje->id; ?>
                        </td>
                        <td class="table__td">
                            <?php echo $viaje->ruta->nombre; ?>
                        </td>
                        <td class="table__td">
                            <?php echo $viaje->chofer->nombre; ?>
                        </td>
                        <td class="table__td">
                            <?php echo $viaje->cantidadfacturas; ?>
                        </td>
                        <td class="table__td">
                            <?php echo $viaje->clientesatendidos; ?>
                        </td>
                        <td class="table__td">
                            <?php
                            $horaalta = $viaje->horaalta;
                            $hora_formateada = date('h:i A', strtotime($horaalta));
                            echo $hora_formateada;
                            ?>
                        </td>
                        <td class="table__td">
                            <?php if ($viaje->horallegada === '00:00:00') { ?>
                                <p class="table__td table__td--asignar">Sin asignar</p>
                            <?php } else {
                                $hora_formateada = date('h:i A', strtotime($viaje->horallegada));
                                echo $hora_formateada;
                            }
                            ?>
                        </td>
                        <td class="table__td--acciones">
                            <a class="table__accion table__accion--editar"
                                href="/admin/index/editar?id=<?php echo $viaje->id; ?>&fecha=<?php echo $viaje->fechaviaje; ?>">
                                <i class="fa-solid fa-pencil"></i>
                                Editar
                            </a>
                            <button class="table__accion table__accion--eliminar" id="viaje"
                                data-id="<?php echo $viaje->id; ?>">
                                <i class="fa-solid fa-trash"></i>
                                Eliminar
                            </button>

                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    <?php } else { ?>
        <p class="text-center">No hay Viajes en la fecha seleccionada...</p>
    <?php } ?>