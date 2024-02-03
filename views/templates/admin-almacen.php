<tr class="table__tr table__tr<?php echo ($almacen->estado !== '0') ? '--disabled' : ''; ?>">
    <td class="table__td">

        <?php echo $almacen->id; ?>
    </td>
    <td class="table__td">
        <p>id:
            <?php echo $almacen->folio_cliente; ?>
        </p>
        <p>
            <?php echo $almacen->cliente; ?>
        </p>
    </td>

    <td class="table__td">
        <?php echo $almacen->factura; ?>
    </td>

    <td class="table__td">
        <p>Folio:
            <?php echo $almacen->folio_material; ?>
        </p>
        <p>
            <?php echo $almacen->material; ?>
        </p>
        <p>Precio: $
            <?php echo $almacen->precio; ?>
        </p>
        <p>Piesas:
            <?php echo $almacen->piezas; ?>
        </p>
        <p>Total: $
            <?php echo $almacen->total; ?>
        </p>
    </td>
    <td class="table__td">
        <?php echo $almacen->chofer; ?>
    </td>

    <td class="table__td">
        <p>Estado:
            <?php echo $almacen->estado; ?>
        </p>
    </td>
    <?php if ($almacen->almacen === '1') { ?>
        <td class="table__td">
            <?php echo $almacen->taka; ?>
        </td>
    <?php } ?>
    <?php if ($almacen->almacen === '2') { ?>
        <td class="table__td">
            <?php echo $almacen->calero; ?>
        </td>
    <?php } ?>
    <?php if ($almacen->almacen === '4') { ?>
        <td class="table__td">
            <?php echo $almacen->calero; ?>
        </td>
    <?php } ?>

    <td class="table__td table__td--acciones">
        <?php if ($almacen->estado === '0') { ?>
            <a class="table__accion table__accion--editar"
                href="/admin/devoluciones/editar?id=<?php echo $almacen->folio_ruta; ?>">
                <i class="fa-solid fa-pencil"></i>
                Editar
            </a>
        <?php } ?>

        <input type="hidden" name="id" value="<?php echo $almacen->id; ?>">
        <button class="table__accion table__accion--eliminar" 
                <?php echo ($almacen->estado !== '0') ? 'disabled' : ''; ?>
                data-id="<?php echo $almacen->id; ?>"
                id="devolucion"
                >
            <i class="fa-solid fa-ban"></i>
            <?php echo ($almacen->estado !== '0') ? 'Cancelada' : 'Cancelar'; ?>
        </button>
        <button class="table__accion table__accion--detalle" id="detalle" data-id="<?php echo $almacen->id; ?>">
            <i class="fa-solid fa-circle-info"></i>
            Detalles
        </button>
    </td>
</tr>