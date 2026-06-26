<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro Estudiantil | UDConnect</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex align-items-center min-vh-100">

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow-sm border-0 p-4">
                <div class="card-body">
                    <h2 class="card-title fw-bold text-primary mb-1">Registro de Estudiantes</h2>
                    <p class="text-muted mb-4">Crea tu cuenta para empezar a gestionar tus proyectos.</p>
                    
                    <form action="guardar_usuario.php" method="POST">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nombre Completo</label>
                            <input type="text" name="nombre" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Correo Institucional</label>
                            <input type="email" name="correo" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Contraseña</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>

                        <div class="row">
                            <div class="col-md-8 mb-3">
                                <label class="form-label fw-semibold">Programa Académico</label>
                                <input type="text" name="programa" class="form-control" placeholder="Ej: Ing. Sistemas" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-semibold">Semestre</label>
                                <input type="number" name="semestre" class="form-control" min="1" max="12" required>
                            </div>
                        </div>

                        <div class="d-grid mt-2">
                            <button type="submit" class="btn btn-primary btn-lg fw-bold">Registrarse</button>
                        </div>
                    </form>

                    <div class="text-center mt-3">
                        <a href="login.php" class="text-decoration-none small">¿Ya tienes cuenta? Inicia sesión aquí</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>