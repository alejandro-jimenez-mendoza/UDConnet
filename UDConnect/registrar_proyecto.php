<?php
include("includes/auth.php");
include("includes/conexion.php");

if(!isset($_SESSION['id_usuario'])){
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Proyecto | UDConnect</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<?php include("includes/header_udc.php"); ?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <h2 class="card-title fw-bold text-primary mb-4">Registrar Nuevo Proyecto</h2>
                    
                    <form action="guardar_proyecto.php" method="POST">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Título del Proyecto</label>
                            <input type="text" name="titulo" class="form-control" required placeholder="Escribe el nombre de tu proyecto...">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Descripción</label>
                            <textarea name="descripcion" class="form-control" rows="4" placeholder="Describe brevemente de qué trata tu proyecto..."></textarea>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold">Categoría</label>
                            <select name="categoria" class="form-select">
                                <option value="Investigación">Investigación</option>
                                <option value="Innovación">Innovación</option>
                                <option value="Emprendimiento">Emprendimiento</option>
                                <option value="Desarrollo Tecnológico">Desarrollo Tecnológico</option>
                            </select>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg fw-bold">Guardar Proyecto</button>
                        </div>
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