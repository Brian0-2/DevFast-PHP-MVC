<div class="boleta swiper-slide">
    <div class="boleta__header">
        <p class="boleta__header">Num Dev# <span> <?php echo $almacen->id; ?> </span></p>
        <p class="boleta__header">fecha: <span><?php echo $almacen->fecha; ?></span></p>
    </div>
    <div class="boleta__informacion">
        <fieldset class="boleta__fieldset">
            <legend class="boleta__legend">Detalle Cliente</legend>
            <div class="boleta__clientes">
                <p class="boleta__cliente">Folio: <span><?php echo $almacen->folio_cliente; ?></span></p>
                <p class="boleta__cliente">Nombre: <span><?php echo $almacen->cliente; ?></span></p>
            </div>
        </fieldset>
        <fieldset class="boleta__fieldset">
            <legend class="boleta__legend">Detalle Material</legend>
            <div class="boleta__folio">
                <p class="boleta__folio">Folio: <span><?php echo $almacen->folio_material; ?></span></p>
                <p class="boleta__folio">Factura: <span><?php echo $almacen->factura; ?></span></p>
            </div>
            <p class="boleta__informacion">Material: <span><?php echo $almacen->material; ?></span></p>
            <div class="boleta__totales">
                <p class="boleta__informacion">Piezas: <span><?php echo $almacen->piezas; ?></span></p>
                <p class="boleta__informacion">Precio: <span><?php echo "$" . $almacen->precio; ?></span></p>
                <p class="boleta__informacion">Total: <span><?php echo "$" . $almacen->total; ?></span></p>
            </div>
        </fieldset>
        <p class="boleta__informacion">Motivo: <span><?php echo $almacen->motivo; ?></span></p>
        <p class="boleta__informacion">Detalle del Motivo: <span><?php echo $almacen->descripcion; ?></span></p>
        <div class="boleta__estados">
            <p class="boleta__estado">Calero: <span><?php echo ($almacen->calero === '0') ? 'Pendiente' : 'Revisado'; ?></span></p>
            <p class="boleta__estado">Macario: <span><?php echo ($almacen->macario === '0') ? 'Pendiente' : 'Revisado'; ?></span></p>
        </div>
    </div>
</div>