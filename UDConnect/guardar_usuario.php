<?php
include("includes/conexion.php");

// 1. Capturar los datos del formulario de forma segura
$nombre = mysqli_real_escape_string($conn, $_POST['nombre']);
$correo = mysqli_real_escape_string($conn, $_POST['correo']);
$rol = mysqli_real_escape_string($conn, $_POST['rol']);
$programa = isset($_POST['programa']) ? mysqli_real_escape_string($conn, $_POST['programa']) : 'N/A';

// 2. 🔒 Cifrar la contraseña con Bcrypt antes de que toque la Base de Datos
$password_plana = $_POST['password'];
$password_cifrada = password_hash($password_plana, PASSWORD_BCRYPT);

// 3. Insertar en la base de datos usando la clave encriptada
$sql = "INSERT INTO usuarios (nombre, correo, password, rol, programa) 
        VALUES ('$nombre', '$correo', '$password_cifrada', '$rol', '$programa')";

if(mysqli_query($conn, $sql)) {
    // Redirección limpia al login si todo sale bien
    header("Location: login.php?registro=exitoso");
} else {
    echo "Error al registrar usuario: " . mysqli_error($conn);
}
exit();
?>