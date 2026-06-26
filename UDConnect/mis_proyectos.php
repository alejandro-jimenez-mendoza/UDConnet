<?php
include("includes/auth.php");
include("includes/conexion.php");

if(!isset($_SESSION['id_usuario'])){
    header("Location: login.php");
    exit();
}

$id_usuario = $_SESSION['id_usuario'];
$sql = "SELECT * FROM proyectos WHERE autor_id='$id_usuario'";
$resultado = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Proyectos | UDConnect</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<?php include("includes/header_udc.php"); ?>

<div class="container my-5">
    <div class="card shadow-sm border-0">
        <div class="card-body p-4">
            <h2 class="card-title fw-bold text-secondary mb-4">Mis Proyectos</h2>
            
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>Título</th>
                            <th>Categoría</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($fila = mysqli_fetch_assoc($resultado)): ?>
                        <tr>
                            <td class="fw-semibold"><?php echo $fila['titulo']; ?></td>
                            <td><?php echo $fila['categoria']; ?></td>
                            <td>
                                <span class="badge bg-info text-dark"><?php echo $fila['estado']; ?></span>
                            </td>
                            <td>
                                <a href="detalle_proyecto.php?id=<?php echo $fila['id_proyecto']; ?>" class="btn btn-sm btn-outline-primary">Ver</a>
                                <a href="editar_proyecto.php?id=<?php echo $fila['id_proyecto']; ?>" class="btn btn-sm btn-outline-secondary">Editar</a>
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