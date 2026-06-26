<?php
include("includes/auth.php");
include("includes/conexion.php");

// Verificación de sesión
if(!isset($_SESSION['id_usuario'])){
    header("Location: login.php");
    exit();
}

$id = $_GET['id'];
$id_usuario = $_SESSION['id_usuario'];
$rol_usuario = $_SESSION['rol'];

// Validación de propietario
if ($rol_usuario === 'admin') {
    $sql = "SELECT * FROM proyectos WHERE id_proyecto='$id'";
} else {
    $sql = "SELECT * FROM proyectos WHERE id_proyecto='$id' AND autor_id='$id_usuario'";
}

$resultado = mysqli_query($conn, $sql);

if (mysqli_num_rows($resultado) == 0) {
    die("<div class='container my-5'><div class='alert alert-danger text-center fw-bold'>Acceso denegado: No tienes permisos para acceder a este proyecto.</div></div>");
}

$proyecto = mysqli_fetch_assoc($resultado);

// Consultas de contenido
$sqlAvances = "SELECT * FROM avances WHERE proyecto_id='$id' ORDER BY fecha DESC";
$resultadoAvances = mysqli_query($conn, $sqlAvances);

$sqlArchivos = "SELECT * FROM archivos WHERE proyecto_id='$id' ORDER BY fecha_subida DESC";
$resultadoArchivos = mysqli_query($conn, $sqlArchivos);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $proyecto['titulo']; ?> | UDConnect</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<?php include("includes/header_udc.php"); ?>

<div class="container my-5">
    <!-- Cabecera del Proyecto -->
    <div class="p-4 mb-4 bg-white rounded shadow-sm border">
        <h1 class="display-6 fw-bold text-primary mb-2"><?php echo $proyecto['titulo']; ?></h1>
        <div class="row text-muted small">
            <div class="col-md-4"><strong>Categoría:</strong> <?php echo $proyecto['categoria']; ?></div>
            <div class="col-md-4"><strong>Estado:</strong> <span class="badge bg-info text-dark"><?php echo $proyecto['estado']; ?></span></div>
            <div class="col-md-4"><strong>Creado el:</strong> <?php echo $proyecto['fecha_creacion']; ?></div>
        </div>
        <hr>
        <h5 class="fw-bold">Descripción del Proyecto:</h5>
        <p class="text-secondary" style="text-align: justify;"><?php echo nl2br($proyecto['descripcion']); ?></p>
    </div>

    <div class="row">
        <!-- Columna Izquierda: Avances y Observaciones -->
        <div class="col-md-7">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body">
                    <h4 class="card-title fw-bold text-secondary mb-3">Registrar Nuevo Avance</h4>
                    <form action="guardar_avance.php" method="POST">
                        <input type="hidden" name="proyecto_id" value="<?php echo $id; ?>">
                        <div class="mb-3">
                            <textarea name="descripcion" class="form-control" rows="3" placeholder="¿Qué progreso se realizó hoy en el proyecto?" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-success btn-sm fw-bold">Guardar Avance</button>
                    </form>
                </div>
            </div>

            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body">
                    <h4 class="card-title fw-bold text-secondary mb-3">Historial de Avances</h4>
                    <?php if(mysqli_num_rows($resultadoAvances) > 0): ?>
                        <div class="list-group list-group-flush">
                            <?php while($avance = mysqli_fetch_assoc($resultadoAvances)): ?>
                                <div class="list-group-item px-0 py-3">
                                    <p class="mb-1 text-dark"><?php echo $avance['descripcion']; ?></p>
                                    <small class="text-muted">📅 <?php echo $avance['fecha']; ?></small>
                                </div>
                            <?php endwhile; ?>
                        </div>
                    <?php else: ?>
                        <p class="text-muted small my-2">No hay avances registrados aún.</p>
                    <?php endif; ?>
                </div>
            </div>
            
            <div class="card shadow-sm border-0 mb-5">
                <div class="card-body">
                    <h4 class="card-title fw-bold text-primary mb-3">Observaciones Docentes</h4>
                    <?php
                    $sqlObs = "SELECT o.*, u.nombre FROM observaciones o INNER JOIN usuarios u ON o.docente_id = u.id_usuario WHERE o.proyecto_id='$id' ORDER BY o.fecha DESC";
                    $resultadoObs = mysqli_query($conn, $sqlObs);
                    
                    if(mysqli_num_rows($resultadoObs) > 0): ?>
                        <div class="list-group">
                            <?php while($obs = mysqli_fetch_assoc($resultadoObs)): ?>
                                <div class="list-group-item border-start border-primary border-4 py-3">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-1 fw-bold text-dark">👤 <?php echo $obs['nombre']; ?></h6>
                                        <small class="text-muted"><?php echo $obs['fecha']; ?></small>
                                    </div>
                                    <p class="mb-1 mt-2 text-secondary"><?php echo $obs['comentario']; ?></p>
                                </div>
                            <?php endwhile; ?>
                        </div>
                    <?php else: ?>
                        <p class="text-muted small my-2">No tienes observaciones docentes registradas en este proyecto.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Columna Derecha: Archivos -->
        <div class="col-md-5">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body">
                    <h4 class="card-title fw-bold text-secondary mb-3">Subir Evidencia</h4>
                    <form action="subir_archivo.php" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="proyecto_id" value="<?php echo $id; ?>">
                        <div class="mb-3">
                            <label class="form-label text-muted small">Selecciona un archivo (PDF, DOCX, Img, PPTX)</label>
                            <input class="form-control form-control-sm" type="file" name="archivo" required>
                        </div>
                        <button type="submit" class="btn btn-primary btn-sm fw-bold">📁 Subir Documento</button>
                    </form>
                </div>
            </div>

            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h4 class="card-title fw-bold text-secondary mb-3">Documentos y Evidencias</h4>
                    <?php if(mysqli_num_rows($resultadoArchivos) > 0): ?>
                        <div class="list-group">
                            <?php while($archivo = mysqli_fetch_assoc($resultadoArchivos)): ?>
                                <a href="<?php echo $archivo['ruta_archivo']; ?>" target="_blank" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                    <span class="text-truncate me-2">📄 <?php echo str_replace("uploads/", "", $archivo['nombre_archivo']); ?></span>
                                    <span class="badge bg-secondary rounded-pill small">Descargar</span>
                                </a>
                            <?php endwhile; ?>
                        </div>
                    <?php else: ?>
                        <p class="text-muted small my-2">No se han cargado archivos para este proyecto.</p>
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