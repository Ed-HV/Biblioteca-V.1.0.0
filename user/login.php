<?php
include 'conexion.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $matricula_credencial = $_POST['matricula_credencial'];

    $sql = "SELECT * FROM usuarios WHERE matricula_credencial = '$matricula_credencial'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $usuario = $result->fetch_assoc();
        $_SESSION['id_usuario'] = $usuario['id_usuario'];
        $_SESSION['nombre'] = $usuario['nombre'];
        header('Location: dashboard.php'); // Redirige al módulo de búsqueda
        exit();
    } else {
        $error = "❌ Credenciales incorrectas. Intenta de nuevo.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Iniciar Sesión - Biblioteca</title>

    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- CSS Personalizado -->
    <link rel="stylesheet" href="assets/css/loginStyle.css">

</head>
<body class=bg-black text-aqua>

<div class="container">
    <div class="card bg-black">
        <h2 class="card-title text-center">Universidad Tecnológica NovaHorizonte</h2>
        <h2 class="card-title text-center">Iniciar Sesión</h2>

        <?php if (!empty($error)): ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="login.php">
            <div class="mb-3">
                <label class="form-label">Matrícula/Credencial:</label>
                <input type="text" name="matricula_credencial" class="form-control" placeholder="Ingresa tu matrícula" required>
            </div>

            <button type="submit" class="btn btn-success w-100">Iniciar Sesión</button>
        </form>
    </div>
</div>

</body>
</html>
