<header class="dashboard__header">
    <div class="dashboard__header-grid">

        <div class="dashboard__header-contenido">
            <h2 class="dashboard__logo">&#60;DevFast></h2>
            <p class="dashboard__header-contenido-texto">Bienvenido! <?php echo $_SESSION['nombre']; ?></p>
        </div>

        <div class="dashboard__header-contenido">
            <nav class="dashboard__nav">
                <a class="dashboard__form" href="/logout">
                    <p class="dashboard__submit--logout">Cerrar Sesion</p>
                </a>
            </nav>
        </div>

    </div>
</header>