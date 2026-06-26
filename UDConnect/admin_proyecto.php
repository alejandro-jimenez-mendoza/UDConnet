<?php
include("includes/admin.php");
include("includes/conexion.php");

if(!isset($_SESSION['rol']) || $_SESSION['rol'] != 'admin'){
    header("Location: dashboard.php");
    exit();
}

$id = $_GET['id'];

$sql = "SELECT p.*, u.nombre FROM proyectos p INNER JOIN usuarios u ON p.autor_id = u.id_usuario WHERE p.id_proyecto='$id'";
$resultado = mysqli_query($conn, $sql);
$proyecto = mysqli_fetch_assoc($resultado);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionar Proyecto | UDConnect</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<?php include("includes/header_udc.php"); ?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <h2 class="fw-bold text-primary mb-4"><?php echo htmlspecialchars($proyecto['titulo']); ?></h2>
                    
                    <div class="mb-4">
                        <p class="mb-1 text-muted"><strong>Autor:</strong> <?php echo htmlspecialchars($proyecto['nombre']); ?></p>
                        <p class="mb-1 text-muted"><strong>Descripción:</strong></p>
                        <p class="bg-white p-3 border rounded"><?php echo nl2br(htmlspecialchars($proyecto['descripcion'])); ?></p>
                        <p class="text-muted"><strong>Estado Actual:</strong> <span class="badge bg-info text-dark"><?php echo $proyecto['estado']; ?></span></p>
                    </div>

                    <hr>

                    <h4 class="fw-bold text-secondary mb-3">Cambiar Estado del Proyecto</h4>
                    <form action="actualizar_estado.php" method="POST">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        
                        <div class="mb-3">
                            <select name="estado" class="form-select">
                                <option value="Propuesta" <?php if($proyecto['estado'] == 'Propuesta') echo 'selected'; ?>>Propuesta</option>
                                <option value="En desarrollo" <?php if($proyecto['estado'] == 'En desarrollo') echo 'selected'; ?>>En desarrollo</option>
                                <option value="Finalizado" <?php if($proyecto['estado'] == 'Finalizado') echo 'selected'; ?>>Finalizado</option>
                            </select>
                        </div>
                        
                        <button type="submit" class="btn btn-primary w-100 fw-bold">Actualizar Estado</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include("includes/footer.php"); ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>