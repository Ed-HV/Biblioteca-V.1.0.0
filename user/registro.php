<?php
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $nombre = $_POST['nombre'];
    $tipo_usuario = $_POST['tipo_usuario'];
    $matricula_credencial = $_POST['matricula_credencial'];
    $nivel_educativo = $_POST['nivel_educativo'];
    $email = $_POST['email'];
    $telefono = $_POST['telefono'];

    if (empty($nivel_educativo)) {
        $mensaje = "Rellena Todos Los Campos.";
    } else {
        // Verificar si la matrícula ya está registrada
        $verificar = "SELECT * FROM usuarios WHERE matricula_credencial = '$matricula_credencial'";
        $resultado = $conn->query($verificar);

        if ($resultado->num_rows > 0) {
            $mensaje = "⚠️ La matrícula o credencial ya está registrada.";
        } else {
            // Insertar el nuevo usuario
            $sql = "INSERT INTO usuarios (nombre, tipo_usuario, matricula_credencial, nivel_educativo, email, telefono)
                    VALUES ('$nombre', '$tipo_usuario', '$matricula_credencial', '$nivel_educativo', '$email', '$telefono')";

            if ($conn->query($sql) === TRUE) {
                $mensaje = "✅ Registro exitoso. Ahora puedes iniciar sesión.";
            } else {
                $mensaje = "❌ Error al registrar usuario: " . $conn->error;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registro de Usuario - Biblioteca</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    
    <link rel="stylesheet" href="assets/css/registroStyle.css">
</head>
<body>

<div class="container mt-5">
   <h2>Universidad Tecnológica NovaHorizonte</h2>
    <h2> Registro de Usuario</h2>

    <?php if (isset($mensaje)): ?>
        <div class="alert alert-info text-center"><?php echo $mensaje; ?></div>
    <?php endif; ?>

    <form method="POST" action="registro.php" class="needs-validation" novalidate>
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre Completo</label>
            <input type="text" name="nombre" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="tipo_usuario" class="form-label">Tipo de Usuario</label>
            <select name="tipo_usuario" class="form-control" required>
                <option value="">Selecciona...</option>
                <option value="Alumno">Alumno</option>
                <option value="Profesor">Profesor</option>
                <option value="Profesor y Alumno">Profesor y Alumno</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="matricula_credencial" class="form-label">Matrícula/Credencial</label>
            <input type="text" name="matricula_credencial" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="nivel_educativo" class="form-label">Nivel Educativo</label>
            <select name="nivel_educativo" class="form-control" required>
                <option value="">Selecciona el nivel...</option>
                <option value="Preparatoria">Preparatoria</option>
                <option value="Profesional">Profesional (Universidad)</option>
                <option value="Maestría">Maestría</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Correo Electrónico</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="telefono" class="form-label">Teléfono</label>
            <input type="text" name="telefono" class="form-control">
        </div>

        <button type="submit" class="btn btn-success w-100">Registrarse</button>
        <a href="login.php" class="btn btn-secondary w-100 mt-2">Iniciar Sesión</a>
    </form>
</div>

<!-- Bootstrap 5 JS + Popper.js -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- script personalizado -->
<script src="assets/js/scripts.js"></script>

</body>
</html>
