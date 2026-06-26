<?php
include("includes/auth.php");
include("includes/conexion.php");

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES['archivo'])) {
    $proyecto_id = $_POST['proyecto_id'];
    $nombre = $_FILES['archivo']['name'];
    $temp = $_FILES['archivo']['tmp_name'];
    $tamano = $_FILES['archivo']['size']; // Capturamos el tamaño en bytes
    
    $id_usuario = $_SESSION['id_usuario'];
    $rol_usuario = $_SESSION['rol'];

    // =========================================================================
    // 1. VALIDACIÓN DE PROPIETARIO (FASE 13.3)
    // =========================================================================
    if ($rol_usuario !== 'admin') {
        $sqlValidacion = "SELECT * FROM proyectos WHERE id_proyecto='$proyecto_id' AND autor_id='$id_usuario'";
        $resValidacion = mysqli_query($conn, $sqlValidacion);
        
        if (mysqli_num_rows($resValidacion) == 0) {
            die("<div style='color:red; font-weight:bold; text-align:center; margin-top:50px;'>Error crítico: No tienes autorización para subir archivos a este proyecto.</div>");
        }
    }

    // =========================================================================
    // 2. VALIDACIÓN DE EXTENSIÓN (FASE 13.4)
    // =========================================================================
    $extension = strtolower(pathinfo($nombre, PATHINFO_EXTENSION));
    $permitidos = ['pdf', 'doc', 'docx', 'ppt', 'pptx', 'jpg', 'jpeg', 'png'];

    if (!in_array($extension, $permitidos)) {
        die("<div style='color:red; font-weight:bold; text-align:center; margin-top:50px;'>Error: Tipo de archivo no permitido. Solo se aceptan documentos y fotos.</div>");
    }

    // =========================================================================
    // 3. VALIDACIÓN DE TAMAÑO MÁXIMO 5 MB (FASE 13.4)
    // =========================================================================
    // 5,000,000 bytes = 5 Megabytes
    if ($tamano > 5000000) {
        die("<div style='color:red; font-weight:bold; text-align:center; margin-top:50px;'>Error: El archivo supera el límite de 5 MB permitido.</div>");
    }
    
    // =========================================================================
    // 4. RENOMBRADO SEGURO (Evita colisiones de nombres con la marca de tiempo)
    // =========================================================================
    $nombre_limpio = time() . "_" . str_replace(" ", "_", $nombre);
    $ruta = "uploads/" . $nombre_limpio;

    // Movemos el archivo solo si superó de manera impecable los 3 filtros previos
    if(move_uploaded_file($temp, $ruta)) {
        // Guardamos la referencia en la base de datos
        $sql = "INSERT INTO archivos (proyecto_id, nombre_archivo, ruta_archivo) 
                VALUES ('$proyecto_id', '$nombre_limpio', '$ruta')";
        
        mysqli_query($conn, $sql);
    }
    
    // Redireccionamos con éxito de vuelta a la interfaz del proyecto
    header("Location: detalle_proyecto.php?id=" . $proyecto_id);
    exit();
} else {
    header("Location: dashboard.php");
    exit();
}
?>