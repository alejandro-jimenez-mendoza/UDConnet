<div class="offcanvas offcanvas-start" tabindex="-1" id="sidebarMenu">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title">Menú UDConnect</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body">
        <ul class="nav nav-pills flex-column mb-auto">
            <li class="nav-item"><a href="dashboard.php" class="nav-link">Dashboard</a></li>
            
            <!-- Menú dinámico según el ROL -->
            <?php if(isset($_SESSION['rol'])): ?>
                
                <?php if($_SESSION['rol'] == 'admin'): ?>
                    <li><a href="usuarios.php" class="nav-link">Gestionar Usuarios</a></li>
                    <li><a href="proyectos.php" class="nav-link">Todos los Proyectos</a></li>
                
                <?php elseif($_SESSION['rol'] == 'docente'): ?>
                    <li><a href="proyectos_docente.php" class="nav-link">Mis Proyectos Asignados</a></li>
                
                <?php elseif($_SESSION['rol'] == 'estudiante'): ?>
                    <li><a href="registrar_proyecto.php" class="nav-link">Registrar Proyecto</a></li>
                    <li><a href="mis_proyectos.php" class="nav-link">Mis Proyectos</a></li>
                <?php endif; ?>
                
            <?php endif; ?>

            <li><hr class="dropdown-divider"></li>
            <li><a href="logout.php" class="nav-link text-danger">Cerrar Sesión</a></li>
        </ul>
    </div>
</div>