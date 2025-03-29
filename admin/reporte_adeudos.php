<?php
include 'conexion.php';

// Consulta SQL optimizada
$query = "SELECT m.id_multa, p.id_prestamo, m.monto, m.fecha_registro, m.estado, u.nombre AS nombre_usuari
          FROM multas m
          JOIN prestamos p ON m.id_prestamo = p.id_prestamo
          JOIN usuarios u ON p.id_usuario = u.id_usuario
          WHERE m.estado = 'pendiente'
          ORDER BY m.fecha_registro ASC";

$resultado = $conn->query($query);

// Manejo de errores mejorado
if (!$resultado) {
    die("Error en la consulta: " . $conn->error);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Adeudos</title>
   <link rel="stylesheet" href="assets/css/adeudoStyle.css"> 
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h2 class="text-center neon-text">Reporte de Adeudos</h2>
        
        <?php if ($resultado->num_rows > 0): ?>
            <table class="tabla-multas">
                <thead>
                    <tr>
                        <th>ID Multa</th>
                        <th>Nombre Usuario</th>
                        <th>ID Prestamo</th>
                        <th>Monto</th>
                        <th>Fecha de Registro</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($fila = $resultado->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($fila['id_multa']); ?></td>
                        <td><?php echo htmlspecialchars($fila['nombre_usuari']); ?></td>
                        <td><?php echo htmlspecialchars($fila['id_prestamo']); ?></td>
                        <td class="monto">$<?php echo number_format($fila['monto'], 2); ?></td>
                        <td><?php echo date('d/m/Y', strtotime($fila['fecha_registro'])); ?></td>
                        <td><?php echo htmlspecialchars($fila['estado']); ?></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="no-resultados">No hay adeudos pendientes.</p>
        <?php endif; ?>

        <!-- Botón corregido para volver al Dashboard -->
        <div class="text-center mt-4">
            <a href="dashboard.php" class="btn-volver">Volver al Dashboard</a>
        </div>
    </div>
</body>
</html>
