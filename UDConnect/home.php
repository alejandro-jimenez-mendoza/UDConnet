<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UDConnect - Universidad de Cartagena</title>
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Tus estilos institucionales (ESTO ES LO NUEVO) -->
    <link rel="stylesheet" href="css/estilos_udc.css">
</head>
<body>

<!-- Incluimos navegación y menú lateral -->
<?php 
    include("includes/navbar.php"); 
    include("includes/sidebar.php"); 
?>

<div class="container my-5">
    <div class="p-5 mb-4 bg-white rounded-3 shadow-sm border text-center text-md-start">
        <div class="container-fluid py-5">
            <!-- El color azul se aplicará desde tu CSS -->
            <h1 class="display-4 fw-bold text-primary">UDConnect</h1>
            <p class="col-md-8 fs-4 text-secondary">
                La plataforma definitiva para el seguimiento, trazabilidad y visibilidad de los proyectos estudiantiles de la Universidad de Cartagena.
            </p>
            <div class="mt-4">
                <!-- btn-primary ahora será el amarillo institucional -->
                <a href="explorar_proyectos.php" class="btn btn-primary btn-lg px-4 me-md-2 fw-bold">  Explorar Proyectos</a>
                
                <?php if(!isset($_SESSION['id_usuario'])): ?>
                    <a href="login.php" class="btn btn-outline-secondary btn-lg px-4 fw-bold">  Iniciar Sesión</a>
                <?php else: ?>
                    <!-- Cambiado a btn-primary para mantener coherencia -->
                    <a href="dashboard.php" class="btn btn-primary btn-lg px-4 fw-bold">  Ir a mi Panel</a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Sección de características -->
    <div class="row g-4 py-5 row-cols-1 row-cols-lg-4">
        <div class="feature col">
            <div class="text-primary fs-2 mb-2"></div>
            <h3 class="fs-4 fw-bold">Seguimiento Real</h3>
            <p class="text-muted">Bitácora digital detallada para registrar avances y recibir retroalimentación constante.</p>
        </div>
        <div class="feature col">
            <div class="text-primary fs-2 mb-2"></div>
            <h3 class="fs-4 fw-bold">Visibilidad Abierta</h3>
            <p class="text-muted">Vitrina y repositorio público para mitigar la falta de divulgación de proyectos académicos.</p>
        </div>
        <div class="feature col">
            <div class="text-primary fs-2 mb-2"></div>
            <h3 class="fs-4 fw-bold">Trazabilidad</h3>
            <p class="text-muted">Historial cronológico inalterable que demuestra el desarrollo de las ideas de grado.</p>
        </div>
        <div class="feature col">
            <div class="text-primary fs-2 mb-2"></div>
            <h3 class="fs-4 fw-bold">Roles Definidos</h3>
            <p class="text-muted">Control estricto de privilegios y flujos de aprobación para estudiantes y administradores.</p>
        </div>
    </div>
</div>

<?php include("includes/footer.php"); ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>