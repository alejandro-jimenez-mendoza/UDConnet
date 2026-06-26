<?php
include("includes/conexion.php");

// Capturar el término de búsqueda
$buscar = isset($_GET['buscar']) ? $_GET['buscar'] : '';

// Consulta dinámica con filtro LIKE
$sql = "SELECT p.*, u.nombre 
        FROM proyectos p 
        INNER JOIN usuarios u ON p.autor_id = u.id_usuario 
        WHERE p.titulo LIKE '%$buscar%' 
        ORDER BY p.fecha_creacion DESC";

$resultado = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Explorar Proyectos | UDConnect</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Vinculamos tu nuevo diseño café -->
    <link rel="stylesheet" href="css/estilos_udc.css">
</head>
<body>

<!-- Navbar usando las clases café por defecto -->
<nav class="navbar navbar-expand-lg navbar-dark shadow-sm mb-4">
    <div class="container">
        <a class="navbar-brand fw-bold" href="explorar_proyectos.php">UDConnect</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link" href="explorar_proyectos.php">Home</a>
                </li>
            </ul>
            <div class="d-flex">
                <a href="login.php" class="btn btn-outline-light btn-sm">Acceso Institucional</a>
            </div>
        </div>
    </div>
</nav>

<div class="container my-5">
    <div class="text-center mb-5">
        <h1 class="fw-bold">Vitrina de Proyectos</h1>
        <p class="text-muted">Repositorio público de iniciativas académicas e investigación.</p>
    </div>

    <div class="row justify-content-center mb-5">
        <div class="col-md-6">
            <form method="GET" action="explorar_proyectos.php" class="d-flex gap-2">
                <input type="text" name="buscar" class="form-control" value="<?php echo htmlspecialchars($buscar); ?>" placeholder="Buscar proyecto por título...">
                <!-- btn-primary aquí ahora será amarillo -->
                <button type="submit" class="btn btn-primary">Buscar</button>
                <?php if($buscar != ''): ?>
                    <a href="explorar_proyectos.php" class="btn btn-outline-secondary">Limpiar</a>
                <?php endif; ?>
            </form>
        </div>
    </div>

    <div class="row">
        <?php if(mysqli_num_rows($resultado) > 0): ?>
            <?php while($fila = mysqli_fetch_assoc($resultado)): ?>
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100 shadow-sm border-0">
                        <div class="card-body">
                            <h5 class="card-title fw-bold"><?php echo htmlspecialchars($fila['titulo']); ?></h5>
                            <p class="card-text text-muted small mb-2"><strong>Autor:</strong> <?php echo htmlspecialchars($fila['nombre']); ?></p>
                            <p class="card-text small mb-1"><strong>Categoría:</strong> <?php echo $fila['categoria']; ?></p>
                            <p class="card-text small mb-3"><strong>Estado:</strong> <span class="badge bg-secondary"><?php echo $fila['estado']; ?></span></p>
                            <!-- El diseño café del botón se aplicará aquí -->
                            <a href="ver_publico.php?id=<?php echo $fila['id_proyecto']; ?>" class="btn btn-primary btn-sm">Ver Más</a>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="col-12 text-center">
                <p class="text-danger fw-bold">No se encontraron proyectos con ese título.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>