<?php
// 1. Validamos sesión general primero
include("includes/auth.php");

// 2. Si el rol NO es exactamente 'admin', se va expulsado de una
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header("Location: dashboard.php");
    exit();
}
?>