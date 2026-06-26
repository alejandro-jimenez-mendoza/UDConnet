<?php

include("auth.php");

if($_SESSION['rol'] != 'docente'){

    header("Location: dashboard.php");
    exit();

}

?>