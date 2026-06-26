<?php
include("includes/auth.php");
include("includes/conexion.php");

$id = $_POST['id'];
$titulo = $_POST['titulo'];
$descripcion = $_POST['descripcion'];
$categoria = $_POST['categoria'];

$id_usuario = $_SESSION['id_usuario'];
$rol_usuario = $_SESSION['rol'];

// =========================================================================
// VALIDACIÓN DE PROPIETARIO ANTES DE ACTUALIZAR (CON EXCEPCIÓN PARA ADMIN)
// =========================================================================
if ($rol_usuario !== 'admin') {
    // Si no es admin, verificamos que el proyecto realmente le pertenezca
    $sqlValidacion = "SELECT * FROM proyectos WHERE id_proyecto='$id' AND autor_id='$id_usuario'";
    $resValidacion = mysqli_query($conn, $sqlValidacion);
    
    if (mysqli_num_rows($resValidacion) == 0) {
        die("<div style='color:red; font-weight:bold; text-align:center; margin-top:50px;'>Error crítico: No tienes permisos para modificar este proyecto.</div>");
    }
}
// =========================================================================

// Ejecutamos la actualización en la BD (Solo si pasó el filtro de seguridad de arriba)
$sql = "UPDATE proyectos 
        SET titulo='$titulo', descripcion='$descripcion', categoria='$categoria' 
        WHERE id_proyecto='$id'";

if(mysqli_query($conn, $sql)){
    // Si tiene éxito, regresa al listado de sus proyectos
    header("Location: mis_proyectos.php");
} else {
    echo "Error al intentar actualizar el proyecto.";
}
exit();
?>