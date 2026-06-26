<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Si no existe la sesión del usuario, lo mandamos al login de una
if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php");
    exit();
}
?>