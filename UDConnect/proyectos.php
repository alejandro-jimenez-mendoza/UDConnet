<?php
include("includes/admin.php");
include("includes/conexion.php");

// Seguridad: Solo el administrador puede ver este listado global
if(!isset($_SESSION['rol']) || $_SESSION['rol'] != 'admin'){
    header("Location: dashboard.php");
    exit();
}

$sql = "SELECT p.*, u.nombre FROM proyectos p INNER JOIN usuarios u ON p.autor_id = u.id_usuario";
$resultado = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Proyectos - UDConnect</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<?php include("includes/header_udc.php"); ?>

<div class="container my-5">
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <h2 class="card-title fw-bold text-secondary mb-4">Listado General de Proyectos (Admin)</h2>
            
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Título</th>
                            <th>Categoría</th>
                            <th>Estado</th>
                            <th>Autor</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($fila = mysqli_fetch_assoc($resultado)): ?>
                        <tr>
                            <td><?php echo $fila['id_proyecto']; ?></td>
                            <td><?php echo $fila['titulo']; ?></td>
                            <td><?php echo $fila['categoria']; ?></td>
                            <td>
                                <span class="badge bg-info text-dark"><?php echo $fila['estado']; ?></span>
                            </td>
                            <td><?php echo $fila['nombre']; ?></td>
                            <td>
                                <a href="admin_proyecto.php?id=<?php echo $fila['id_proyecto']; ?>" class="btn btn-sm btn-outline-primary">Gestionar</a>
                                <a href="eliminar_proyecto.php?id=<?php echo $fila['id_proyecto']; ?>" 
                                   class="btn btn-sm btn-outline-danger"
                                   onclick="return confirm('¿Estás seguro de eliminar este proyecto y todos sus avances, archivos y observaciones?');">
                                   Eliminar
                                </a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include("includes/footer.php"); ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>