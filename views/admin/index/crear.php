<h3 class="text-center"><?php echo $titulo; ?></h3>
<div class="contenedor-sm">
    <div class="dashboard__contenedor--boton">
        <a class="dashboard__boton" href="/admin/index?fecha=<?php echo $_GET['fecha'];?>">
            <i class="fa-solid fa-circle-arrow-left"></i></i>
            Volver
        </a>
    </div>
<?php include_once 'formulario.php'; ?>
</div>