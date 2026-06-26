<?php
// Forzar reporte de errores para depuración
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include("includes/conexion.php");

// Si ya tiene sesión activa, lo mandamos directo al dashboard
if(isset($_SESSION['id_usuario'])){
    header("Location: dashboard.php");
    exit();
}

$error = "";

// PROCESAR EL FORMULARIO
if($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo = mysqli_real_escape_string($conn, $_POST['correo']);
    $password_escrita = $_POST['password'];

    $sql = "SELECT * FROM usuarios WHERE correo='$correo'";
    $resultado = mysqli_query($conn, $sql);

    if(mysqli_num_rows($resultado) > 0) {
        $usuario = mysqli_fetch_assoc($resultado);
        
        if(password_verify($password_escrita, $usuario['password'])) {
            $_SESSION['id_usuario'] = $usuario['id_usuario'];
            $_SESSION['nombre'] = $usuario['nombre'];
            $_SESSION['rol'] = $usuario['rol'];

            header("Location: dashboard.php");
            exit();
        } else {
            $error = "Contraseña incorrecta. Inténtalo de nuevo.";
        }
    } else {
        $error = "El correo electrónico no se encuentra registrado.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - UDConnect</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<!-- Aquí integramos el menú completo -->
<?php include("includes/header_udc.php"); ?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow border-0 rounded-3">
                <div class="card-body p-5">
                    <h2 class="card-title fw-bold text-center text-primary mb-4">Iniciar Sesión</h2>
                    
                    <?php if($error != ""): ?>
                        <div class="alert alert-danger py-2 small text-center"><?php echo $error; ?></div>
                    <?php endif; ?>

                    <form action="login.php" method="POST">
                        <div class="mb-3">
                            <label class="form-label fw-semibold text-secondary">Correo Electrónico</label>
                            <input type="email" name="correo" class="form-control form-control-lg" required placeholder="ejemplo@correo.com">
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold text-secondary">Contraseña</label>
                            <input type="password" name="password" class="form-control form-control-lg" required placeholder="••••••••">
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg fw-bold">Ingresar</button>
                        </div>
                    </form>

                    <div class="text-center mt-4">
                        <a href="registro.php" class="text-decoration-none">¿No tienes cuenta? Regístrate aquí</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include("includes/footer.php"); ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>