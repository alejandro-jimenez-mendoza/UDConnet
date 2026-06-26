<?php
include("includes/admin.php");
include("includes/conexion.php");

$id = $_POST['id'];
$estado = $_POST['estado'];

$sql = "UPDATE proyectos SET estado='$estado' WHERE id_proyecto='$id'";

mysqli_query($conn, $sql);

header("Location: proyectos.php");
exit();
?>