<?php
include 'conexion.php';
session_start();

if (!isset($_SESSION['id_usuario'])) {
    header('Location: login.php');
    exit();
}

$nombre_usuario = $_SESSION['nombre'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard del Usuario - Biblioteca</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
</head>
<body>

    <div class="d-flex" id="wrapper">

        <!-- Sidebar -->
        <div class="bg-dark border-end" id="sidebar-wrapper">
            <div class="sidebar-heading text-white p-3">📚 Mi Biblioteca</div>
            <div class="list-group list-group-flush">
                <a href="#" class="list-group-item list-group-item-action bg-dark text-white" onclick="loadPage('buscar_libros.php')">Buscar Libros</a>
                <a href="#" class="list-group-item list-group-item-action bg-dark text-white" onclick="loadPage('mis_prestamos.php')">Mis Préstamos</a>
                <a href="#" class="list-group-item list-group-item-action bg-dark text-white" onclick="loadPage('renovar_prestamo.php')">Renovar Préstamos</a>
                <a href="#" class="list-group-item list-group-item-action bg-dark text-white" onclick="loadPage('historial.php')">Historial</a>
                <a href="#" class="list-group-item list-group-item-action bg-dark text-white" onclick="loadPage('notificaciones.php')">Notificaciones</a>
                <a href="logout.php" class="list-group-item list-group-item-action bg-danger text-white">Cerrar Sesión</a>
            </div>
        </div>

        <!-- Contenido principal -->
        <div id="page-content-wrapper" class="p-4">
            <h3>¡Bienvenido, <?php echo htmlspecialchars($nombre_usuario); ?>! 🎉</h3>
            <p>Selecciona una opción del menú para comenzar.</p>
            <div id="content-area"></div>
        </div>

    </div>

    <!-- Bootstrap 5 JS + Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- script personalizado -->
    <script src="assets/js/scripts.js"></script>

</body>
</html>
