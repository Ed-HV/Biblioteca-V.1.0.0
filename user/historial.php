<?php
include 'conexion.php';
session_start();

if (!isset($_SESSION['id_usuario'])) {
    header('Location: login.php');
    exit();
}

$id_usuario = $_SESSION['id_usuario'];

$sql = "SELECT l.titulo, p.fecha_prestamo, p.fecha_devolucion, p.estado_prestamo 
        FROM prestamos p
        JOIN libros l ON p.id_libro = l.id_libro
        WHERE p.id_usuario = '$id_usuario'";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Historial de Préstamos</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/historialStyle.css">
</head>
<body>
    <h2>Historial de Préstamos</h2>
    
    <?php if ($result->num_rows > 0): ?>
        <table class="tabla-neon">
            <tr>
                <th>Título</th>
                <th>Fecha Préstamo</th>
                <th>Fecha Devolución</th>
                <th>Estado</th>
            </tr>
            <?php while ($prestamo = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($prestamo['titulo']) ?></td>
                    <td><?= htmlspecialchars($prestamo['fecha_prestamo']) ?></td>
                    <td><?= htmlspecialchars($prestamo['fecha_devolucion']) ?></td>
                    <td><?= htmlspecialchars($prestamo['estado_prestamo']) ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p class="mensaje-vacio">No tienes historial de préstamos.</p>
    <?php endif; ?>

    <form method="POST" action="dashboard.php">
        <div class="boton-container">
            <input type="submit" value="Dashboard">
        </div>
    </form>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>