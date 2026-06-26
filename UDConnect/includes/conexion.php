<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "udconnect"; // <-- Verifica si tu base de datos se llama exactamente así

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Error de conexión a la base de datos: " . mysqli_connect_error());
}
?>