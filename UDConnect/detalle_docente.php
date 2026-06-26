<?php
include("includes/docente.php");
include("includes/conexion.php");

$id = $_GET['id'];

$sql = "SELECT p.*, u.nombre 
        FROM proyectos p 
        INNER JOIN usuarios u ON p.autor_id = u.id_usuario 
        WHERE p.id_proyecto='$id'";

$resultado = mysqli_query($conn, $sql);
$proyecto = mysqli_fetch_assoc($resultado);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle del Proyecto | UDConnect</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<?php include("includes/header_udc.php"); ?>

<div class="container my-5">
    <div class="row">
        <!-- Columna Principal: Detalles y Avances -->
        <div class="col-md-7">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body p-4">
                    <h2 class="fw-bold text-primary mb-3"><?php echo htmlspecialchars($proyecto['titulo']); ?></h2>
                    <p class="text-muted"><strong>Autor:</strong> <?php echo htmlspecialchars($proyecto['nombre']); ?></p>
                    <p class="text-muted"><strong>Categoría:</strong> <?php echo htmlspecialchars($proyecto['categoria']); ?></p>
                    <p class="text-muted"><strong>Estado:</strong> <span class="badge bg-info text-dark"><?php echo htmlspecialchars($proyecto['estado']); ?></span></p>
                    <hr>
                    <h5 class="fw-bold">Descripción:</h5>
                    <p class="text-secondary"><?php echo nl2br(htmlspecialchars($proyecto['descripcion'])); ?></p>
                </div>
            </div>

            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body p-4">
                    <h4 class="fw-bold text-secondary mb-3">Historial de Avances</h4>
                    <?php
                    $sqlAvances = "SELECT * FROM avances WHERE proyecto_id='$id' ORDER BY fecha DESC";
                    $resultadoAvances = mysqli_query($conn, $sqlAvances);

                    if(mysqli_num_rows($resultadoAvances) > 0): ?>
                        <div class="list-group list-group-flush">
                            <?php while($avance = mysqli_fetch_assoc($resultadoAvances)): ?>
                                <div class="list-group-item px-0">
                                    <p class="mb-1 text-dark"><?php echo htmlspecialchars($avance['descripcion']); ?></p>
                                    <small class="text-muted">📅 <?php echo $avance['fecha']; ?></small>
                                </div>
                            <?php endwhile; ?>
                        </div>
                    <?php else: ?>
                        <p class="text-muted">El estudiante aún no ha registrado avances.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Columna Derecha: Observaciones -->
        <div class="col-md-5">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body p-4">
                    <h4 class="fw-bold text-secondary mb-3">Registrar Observación</h4>
                    <form action="guardar_observacion.php" method="POST">
                        <input type="hidden" name="proyecto_id" value="<?php echo $id; ?>">
                        <div class="mb-3">
                            <textarea name="comentario" class="form-control" rows="4" placeholder="Escribe tus sugerencias o correcciones..." required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 fw-bold">Guardar Observación</button>
                    </form>
                </div>
            </div>

            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <h4 class="fw-bold text-secondary mb-3">Observaciones Registradas</h4>
                    <?php
                    $sqlObs = "SELECT o.*, u.nombre FROM observaciones o INNER JOIN usuarios u ON o.docente_id = u.id_usuario WHERE o.proyecto_id='$id' ORDER BY o.fecha DESC";
                    $resultadoObs = mysqli_query($conn, $sqlObs);

                    if(mysqli_num_rows($resultadoObs) > 0):
                        while($obs = mysqli_fetch_assoc($resultadoObs)): ?>
                            <div class="border-start border-primary border-3 ps-3 mb-3">
                                <p class="mb-1 fw-bold text-dark"><?php echo htmlspecialchars($obs['nombre']); ?></p>
                                <p class="mb-1 text-secondary small"><?php echo htmlspecialchars($obs['comentario']); ?></p>
                                <small class="text-muted"><?php echo $obs['fecha']; ?></small>
                            </div>
                        <?php endwhile;
                    else: ?>
                        <p class="text-muted small">No hay observaciones todavía.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include("includes/footer.php"); ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>