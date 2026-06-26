<?php
include("includes/admin.php");
include("includes/conexion.php");

// Seguridad: Si no es admin, lo expulsamos al dashboard
if(!isset($_SESSION['rol']) || $_SESSION['rol'] != 'admin'){
    header("Location: dashboard.php");
    exit();
}

// =========================================================================
// PROCESADOR PARA CREAR NUEVO DOCENTE O ADMIN
// =========================================================================
$mensaje = "";
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['crear_usuario'])) {
    $nombre = mysqli_real_escape_string($conn, $_POST['nombre']);
    $correo = mysqli_real_escape_string($conn, $_POST['correo']);
    $password = $_POST['password'];
    $rol = mysqli_real_escape_string($conn, $_POST['rol']);
    
    // 1. Validar que el correo no exista ya en la BD
    $verificar = mysqli_query($conn, "SELECT * FROM usuarios WHERE correo='$correo'");
    if (mysqli_num_rows($verificar) > 0) {
        $mensaje = "<div class='alert alert-danger'>El correo ya está registrado en el sistema.</div>";
    } else {
        // 2. Cifrar la contraseña
        $password_cifrada = password_hash($password, PASSWORD_BCRYPT);
        
        // 3. Insertar en la base de datos
        $sqlInsert = "INSERT INTO usuarios (nombre, correo, password, rol, programa, semestre) 
                      VALUES ('$nombre', '$correo', '$password_cifrada', '$rol', NULL, NULL)";
        
        if (mysqli_query($conn, $sqlInsert)) {
            $mensaje = "<div class='alert alert-success'>Usuario con rol <strong>$rol</strong> creado exitosamente.</div>";
        } else {
            $mensaje = "<div class='alert alert-danger'>Error al registrar: " . mysqli_error($conn) . "</div>";
        }
    }
}

// Consulta para listar a todos los usuarios
$sql = "SELECT * FROM usuarios";
$resultado = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Usuarios - UDConnect</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<?php include("includes/header_udc.php"); ?>

<div class="container my-5">
    
    <?php echo $mensaje; ?>

    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h4 class="card-title fw-bold text-danger mb-3">Registrar Personal</h4>
                    <form action="usuarios.php" method="POST">
                        <input type="hidden" name="crear_usuario" value="1">
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Nombre Completo</label>
                            <input type="text" name="nombre" class="form-control form-control-sm" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Correo Institucional</label>
                            <input type="email" name="correo" class="form-control form-control-sm" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Contraseña Provisional</label>
                            <input type="password" name="password" class="form-control form-control-sm" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Asignar Rol</label>
                            <select name="rol" class="form-select form-select-sm" required>
                                <option value="docente" selected>Docente (Evaluador)</option>
                                <option value="admin">Administrador (Soporte)</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-danger btn-sm w-100 fw-bold">💾 Guardar Nuevo Usuario</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h4 class="card-title fw-bold text-secondary mb-3">Usuarios Registrados</h4>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle small">
                            <thead class="table-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Rol</th>
                                    <th>Acción</th> 
                                </tr>
                            </thead>
                            <tbody>
                                <?php while($fila = mysqli_fetch_assoc($resultado)): ?>
                                <tr>
                                    <td><?php echo $fila['id_usuario']; ?></td>
                                    <td><?php echo $fila['nombre']; ?></td>
                                    <td>
                                        <?php 
                                        if($fila['rol'] == 'admin') echo '<span class="badge bg-danger">Admin</span>';
                                        elseif($fila['rol'] == 'docente') echo '<span class="badge bg-success">Docente</span>';
                                        else echo '<span class="badge bg-primary">Estudiante</span>';
                                        ?>
                                    </td>
                                    <td>
                                        <a href="eliminar_usuario.php?id=<?php echo $fila['id_usuario']; ?>" 
                                           class="btn btn-outline-danger btn-sm"
                                           onclick="return confirm('¿Estás seguro de eliminar a este usuario?');">
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
    </div>
</div>

<?php include("includes/footer.php"); ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>