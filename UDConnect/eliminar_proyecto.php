<?php
include("includes/admin.php"); // Asegúrate de que este archivo verifique que sea admin
include("includes/conexion.php");

$id = $_GET['id'];

// 1. Borramos todo lo relacionado primero
mysqli_query($conn, "DELETE FROM observaciones WHERE proyecto_id='$id'");
mysqli_query($conn, "DELETE FROM avances WHERE proyecto_id='$id'");
mysqli_query($conn, "DELETE FROM archivos WHERE proyecto_id='$id'");

// 2. Ahora sí, borramos el proyecto
mysqli_query($conn, "DELETE FROM proyectos WHERE id_proyecto='$id'");

header("Location: proyectos.php");
exit();
?>