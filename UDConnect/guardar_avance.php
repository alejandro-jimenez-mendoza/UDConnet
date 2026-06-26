<?php
include("includes/auth.php");
include("includes/conexion.php");

$proyecto_id = $_POST['proyecto_id'];
$descripcion = $_POST['descripcion'];

$id_usuario = $_SESSION['id_usuario'];
$rol_usuario = $_SESSION['rol'];

// =========================================================================
// VALIDACIÓN DE PROPIETARIO ANTES DE GUARDAR AVANCE (CON EXCEPCIÓN PARA ADMIN)
// =========================================================================
if ($rol_usuario !== 'admin') {
    // Verificamos que el proyecto pertenezca al estudiante conectado
    $sqlValidacion = "SELECT * FROM proyectos WHERE id_proyecto='$proyecto_id' AND autor_id='$id_usuario'";
    $resValidacion = mysqli_query($conn, $sqlValidacion);
    
    if (mysqli_num_rows($resValidacion) == 0) {
        die("<div style='color:red; font-weight:bold; text-align:center; margin-top:50px;'>Error crítico: No tienes autorización para añadir avances a este proyecto.</div>");
    }
}
// =========================================================================

// Si pasa la validación, insertamos el avance de forma segura
$sql = "INSERT INTO avances (proyecto_id, descripcion) VALUES ('$proyecto_id', '$descripcion')";
mysqli_query($conn, $sql);

// Redirección inteligente: lo regresa al mismo proyecto agregando su ID a la URL
header("Location: detalle_proyecto.php?id=" . $proyecto_id);
exit();
?>