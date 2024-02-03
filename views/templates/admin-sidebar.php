<aside class="dashboard__sidebar">
    <nav class="dashboard__menu">
    <a href="/admin/index" class="dashboard__enlace <?php echo pagina_actual('/index') ? 'dashboard__enlace--actual' : '';?>" > 
            <i class="fa-solid fa-house dashboard__icono"></i>
            <span class="dashboard__menu-texto">Main</span>
        </a>
        <a href="/admin/pronosticos" class="dashboard__enlace <?php echo pagina_actual('/pronosticos') ? 'dashboard__enlace--actual' : '';?>" > 
            <i class="fa-solid fa-chart-line  dashboard__icono"></i>
            <span class="dashboard__menu-texto">Pronosticos</span>
        </a>
        <a href="/admin/reportes" class="dashboard__enlace <?php echo pagina_actual('/reportes') ? 'dashboard__enlace--actual' : '';?>" > 
            <i class="fa-solid fa-file-excel  dashboard__icono"></i>
            <span class="dashboard__menu-texto">Reportes</span>
        </a>
        <a href="/admin/rutas" class="dashboard__enlace <?php echo pagina_actual('/rutas') ? 'dashboard__enlace--actual' : '';?>" > 
            <i class="fa-solid fa-truck-fast  dashboard__icono"></i>    
            <span class="dashboard__menu-texto">Rutas</span>
        </a>
        <a href="/admin/devoluciones" class="dashboard__enlace <?php echo pagina_actual('/devoluciones') ? 'dashboard__enlace--actual' : '';?>" > 
            <i class="fa-solid fa-file-contract  dashboard__icono"></i>
            <span class="dashboard__menu-texto">Devoluciones</span>
        </a>
        <a href="/admin/usuarios" class="dashboard__enlace <?php echo pagina_actual('/usuarios') ? 'dashboard__enlace--actual' : '';?>" > 
             <i class="fa-solid fa-users-rectangle  dashboard__icono"></i>
            <span class="dashboard__menu-texto">Usuarios</span>
        </a>
        <a href="/admin/motivos" class="dashboard__enlace <?php echo pagina_actual('/motivos') ? 'dashboard__enlace--actual' : '';?>" > 
            <i class="fa-solid fa-scale-balanced  dashboard__icono"></i>
            <span class="dashboard__menu-texto">Motivos de Dev</span>
        </a>
    </nav>
</aside>