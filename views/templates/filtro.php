<div class="filtro">
    <form class="filtro__formulario" method="POST" action="">
        <label class="filtro__label" for="filtro"> Filtrar:</label>
        <input class="filtro__input" 
               type="text"
               name="filtro"
               id="filtro"
               placeholder="Click y buscar..."
               />
    </form>
    <?php 
        echo $paginacion;
    ?>
</div>