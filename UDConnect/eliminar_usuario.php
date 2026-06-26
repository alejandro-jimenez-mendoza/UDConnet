<?php
include("includes/admin.php");
include("includes/conexion.php");

$id = $_GET['id'];

// Protección contra borrado propio
if($id == $_SESSION['id_usuario']){
    die("Error: No puedes eliminar tu propia cuenta mientras estás logueado.");
}

// Borramos al usuario
mysqli_query($conn, "DELETE FROM usuarios WHERE id_usuario='$id'");

header("Location: usuarios.php");
exit();
?>