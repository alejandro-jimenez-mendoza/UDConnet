<?php
include("includes/conexion.php");

// Validamos que venga un ID por la URL
if(!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: explorar_proyectos.php");
    exit();
}

$id = mysqli_real_escape_string($conn, $_GET['id']);
$sql = "SELECT p.*, u.nombre 
        FROM proyectos p 
        INNER JOIN usuarios u ON p.autor_id = u.id_usuario 
        WHERE p.id_proyecto='$id'";

$resultado = mysqli_query($conn, $sql);
$proyecto = mysqli_fetch_assoc($resultado);

if(!$proyecto) {
    echo "El proyecto solicitado no existe.";
    echo "<br><a href='explorar_proyectos.php'>Volver al listado</a>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($proyecto['titulo']); ?> - Detalle Público</title>
    <!-- Incluimos el puente de estilos que definimos -->
    <?php include("includes/header_udc.php"); ?>
</head>
<body>

<div class="container my-5">
    <div class="mb-4">
        <a href="explorar_proyectos.php" class="btn btn-outline-secondary btn-sm">← Volver a Explorar Proyectos</a>
    </div>

    <!-- Tarjeta principal de detalle -->
    <div class="card shadow-sm border-0 p-4">
        <div class="card-body">
            <h1 class="display-5 fw-bold text-primary"><?php echo htmlspecialchars($proyecto['titulo']); ?></h1>
            <h3 class="text-secondary fs-4">Por: <?php echo htmlspecialchars($proyecto['nombre']); ?></h3>
            
            <hr class="my-4">
            
            <div class="row mb-4">
                <div class="col-md-4">
                    <p><strong>Categoría:</strong> <span class="badge bg-secondary"><?php echo htmlspecialchars($proyecto['categoria']); ?></span></p>
                </div>
                <div class="col-md-4">
                    <p><strong>Estado:</strong> <span class="text-primary fw-bold"><?php echo htmlspecialchars($proyecto['estado']); ?></span></p>
                </div>
                <div class="col-md-4">
                    <p><strong>Publicado:</strong> <?php echo htmlspecialchars($proyecto['fecha_creacion']); ?></p>
                </div>
            </div>

            <h4 class="fw-bold">Descripción del Proyecto:</h4>
            <div class="p-3 bg-light rounded border">
                <p style="line-height: 1.6; text-align: justify;">
                    <?php echo nl2br(htmlspecialchars($proyecto['descripcion'])); ?>
                </p>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>