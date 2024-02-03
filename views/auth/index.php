<?php include_once __DIR__ .'/../templates/header.php'; ?>
<div class="principal">
<main class="contenedor-sm contenedor-grid">
    <picture>
        <source srcset="/../build/img/dev.avif" type="image/avif">
        <source srcset="/../build/img/dev.webp" type="image/webp">
        <source srcset="/../build/img/dev.png" type="image/png">
        <img src="/../build/img/dev.png" width="200px" alt="Imagen">
    </picture>
<form class="formulario" method="POST">
    <?php 
            require_once __DIR__ . '/../templates/alertas.php';
    ?>
        <div class="formulario__campo">
            <label class="formulario__label" for="nombre">Nombre</label>
            <input 
                type="text"
                class="formulario__input"
                placeholder="Coloca tu Nombre"
                id="nombre"
                name="nombre"
            >
        </div>

        <div class="formulario__campo">
            <label class="formulario__label" for="password">Password</label>
            <input 
                type="password"
                class="formulario__input"
                placeholder="Coloca tu password"
                id="password"
                name="password"
            >
        </div>

        <input type="submit" class="formulario__submit" value="Iniciar Sesion">
    </form>
</main>
<?php include_once __DIR__ .'/../templates/footer.php'; ?>
</div>