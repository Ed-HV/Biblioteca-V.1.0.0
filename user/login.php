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
    } else {
        echo "Credenciales incorrectas. Intenta de nuevo.";
    }
}
?>

<!-- Formulario de inicio de sesión -->
<form method="POST" action="login.php">
    Matrícula/Credencial: <input type="text" name="matricula_credencial" required><br>
    <input type="submit" value="Iniciar Sesión">
</form>
<div>
<script src="assets/js/scripts.js"></script>
</div>