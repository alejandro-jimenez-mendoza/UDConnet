<?php 
session_start();
include("includes/auth.php");
include("includes/conexion.php"); 

if(!isset($_SESSION['id_usuario'])){
    header("Location: login.php");
    exit();
}

// Consultas para métricas (Solo si es Admin)
$totalUsuarios = 0; $totalProyectos = 0; $totalDocentes = 0; $totalObservaciones = 0;
if($_SESSION['rol'] == 'admin'){
    $totalUsuarios = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM usuarios"));
    $totalProyectos = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM proyectos"));
    $totalDocentes = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM usuarios WHERE rol='docente'"));
    $totalObservaciones = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM observaciones"));
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | UDConnect</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<?php include("includes/header_udc.php"); ?>

<div class="container my-5">
    <h1>Bienvenido, <?php echo $_SESSION['nombre']; ?></h1>
    <p class="text-muted">Rol: <?php echo ucfirst($_SESSION['rol']); ?></p>
    <hr>

    <?php if($_SESSION['rol'] == 'admin'): ?>
        <div class="row g-4 mb-5">
            <div class="col-md-3"><div class="card text-center shadow-sm"><div class="card-body"><h2><?php echo $totalUsuarios; ?></h2><p>Usuarios</p></div></div></div>
            <div class="col-md-3"><div class="card text-center shadow-sm"><div class="card-body"><h2><?php echo $totalProyectos; ?></h2><p>Proyectos</p></div></div></div>
            <div class="col-md-3"><div class="card text-center shadow-sm"><div class="card-body"><h2><?php echo $totalDocentes; ?></h2><p>Docentes</p></div></div></div>
            <div class="col-md-3"><div class="card text-center shadow-sm"><div class="card-body"><h2><?php echo $totalObservaciones; ?></h2><p>Observaciones</p></div></div></div>
        </div>
        
        <div class="alert alert-light border">
            <p class="mb-0">Utiliza el menú lateral para gestionar la plataforma.</p>
        </div>

    <?php elseif($_SESSION['rol'] == 'docente'): ?>
        <div class="card shadow-sm">
            <div class="card-body">
                <h4 class="card-title">Panel Docente</h4>
                <p class="card-text">Bienvenido al sistema. Consulta tus proyectos asignados desde el menú lateral.</p>
            </div>
        </div>

    <?php else: ?>
        <div class="card shadow-sm">
            <div class="card-body">
                <h4 class="card-title">Panel Estudiante</h4>
                <p class="card-text">Puedes registrar nuevos proyectos o gestionar los existentes a través del menú de navegación.</p>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php include("includes/footer.php"); ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>