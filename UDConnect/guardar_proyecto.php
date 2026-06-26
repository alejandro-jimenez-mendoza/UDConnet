<?php

include("includes/auth.php");

include("includes/conexion.php");

$titulo = $_POST['titulo'];

$descripcion = $_POST['descripcion'];

$categoria = $_POST['categoria'];

$autor = $_SESSION['id_usuario'];

$sql = "INSERT INTO proyectos
(
titulo,
descripcion,
categoria,
autor_id
)

VALUES
(
'$titulo',
'$descripcion',
'$categoria',
'$autor'
)";

if(mysqli_query($conn,$sql)){

    header("Location: proyectos.php");

}else{

    echo "Error al guardar";

}

?>