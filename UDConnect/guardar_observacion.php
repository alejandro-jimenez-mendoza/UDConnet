<?php

include("includes/docente.php");
include("includes/conexion.php");

$proyecto_id = $_POST['proyecto_id'];
$comentario = $_POST['comentario'];
$docente_id = $_SESSION['id_usuario'];

$sql = "INSERT INTO observaciones (proyecto_id, docente_id, comentario) 
        VALUES ('$proyecto_id', '$docente_id', '$comentario')";

mysqli_query($conn, $sql);

header("Location: detalle_docente.php?id=" . $proyecto_id);
exit();

?>