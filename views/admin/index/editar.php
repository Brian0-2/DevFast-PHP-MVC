<h3 class="text-center"><?php echo $titulo; ?></h3>

<div class="contenedor-sm">
    <div class="dashboard__contenedor--boton">
        <a class="dashboard__boton" href="/admin/index?fecha=<?php echo $_GET['fecha']; ?>">
            <i class="fa-solid fa-circle-arrow-left"></i></i>
            Volver
        </a>
    </div>

    <form class="formulario contenedor-sm" method="POST">
        <?php require_once __DIR__ . '/../../templates/alertas.php'; ?>


            <label class="formulario__label" for="chofer">Ruta</label>
            <?php foreach($viajes as $viaje){ ?>
                <label class="formulario__label formulario__label--texto" for="nombre-ruta">
                    <?php echo $viaje -> ruta -> nombre; ?>
                </label>     
            <?php }?>
    
            <br>
            <input type="hidden" name="id" value="<?php echo $viaje -> id; ?>" >
            <input type="hidden" name="fechaviaje" value="<?php echo $viaje -> fechaviaje; ?>" >
            <input type="hidden" name="id_ruta" value="<?php echo $viaje -> id_ruta; ?>" >
         
        <label class="formulario__label" for="chofer">Chofer</label>
        <label class="formulario__label formulario__label--texto" for="nombre-ruta">
                <?php echo $viaje -> usuario -> nombre; ?>
        </label> 
        <input type="hidden" name="id_usuario" value="<?php echo $viaje -> usuario -> id ?>">
            <br>
            
            <select class="formulario__select" name="id_usuario" id="id_usuario">
                <option value="" selected disabled>- Cambiar? -</option>
                <?php foreach($usuarios as $usuario){ ?>
                    <option value="<?php echo $usuario -> id; ?>"> <?php echo $usuario -> nombre; ?></option>
                <?php } ?>
            </select>
        <label class="formulario__label" for="cantidad-facturas">Cantidad Facturas</label>
        <input class="formulario__input formulario__input--cantidadfacturas"
               type="number"
               name="cantidadfacturas"
               id="cantidadfacturas"
               value="<?php echo $viaje -> cantidadfacturas; ?>"
               />
               <label class="formulario__label" for="clientesatendidos">Clientes Atendidos</label>
        <input class="formulario__input formulario__input--clientesatendidos"
               type="number"
               name="clientesatendidos"
               id="clientesatendidos"
               value="<?php echo $viaje -> clientesatendidos; ?>"
               />
        <label class="formulario__label" for="horallegada">Horas llegada</label>
        <input class="formulario__input formulario__input--horas-llegada" 
               type="time"
               id="horallegada"
               name="horallegada"
               value="<?php echo ($viaje -> horallegada === '00:00:00') ? '': $viaje -> horallegada; ?>"
               />
               
        <input class="formulario__submit" type="submit" value="Guardar Cambios">
    </form>

</div>