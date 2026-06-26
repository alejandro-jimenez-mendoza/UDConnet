<nav class="navbar navbar-expand-lg navbar-dark shadow-sm mb-4">
    <div class="container">
        <button class="btn btn-outline-light btn-sm me-3" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarMenu">
            ☰ Menú
        </button>

        <?php
        // Lógica de redirección centralizada
        if (session_status() === PHP_SESSION_NONE) { session_start(); }
        
        $home_url = 'http://localhost/UDConnect/home.php';
        if (isset($_SESSION['rol'])) {
            $rol = trim(strtolower($_SESSION['rol']));
            $mapa_roles = [
                'admin'      => 'dashboard_admin.php',
                'docente'    => 'proyectos_docente.php',
                'estudiante' => 'dashboard.php'
            ];
            $home_url = $mapa_roles[$rol] ?? 'http://localhost/UDConnect/home.php';
        }
        ?>

        <a class="nav-link text-white fw-bold me-3" href="<?php echo $home_url; ?>">Home</a>
        <a class="navbar-brand fw-bold" href="<?php echo $home_url; ?>"> UDConnect</a>
        
        <div class="ms-auto">
            <?php if(isset($_SESSION['id_usuario'])): ?>
                <span class="text-white me-3 d-none d-sm-inline">
                    Hola, <strong><?php echo htmlspecialchars($_SESSION['nombre']); ?></strong> 
                    <small class="text-white-50">(<?php echo ucfirst($_SESSION['rol']); ?>)</small>
                </span>
                <a class="btn btn-primary btn-sm fw-bold" href="logout.php">Cerrar Sesión</a>
            <?php else: ?>
                <a class="btn btn-primary btn-sm fw-bold" href="login.php">Iniciar Sesión</a>
            <?php endif; ?>
        </div>
    </div>
</nav>