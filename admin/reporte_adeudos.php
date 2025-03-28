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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <style>
       
        .tabla-multas {
            width: 100%;
            border-collapse: collapse;
        }

        .tabla-multas th, .tabla-multas td {
            padding: 10px;
            text-align: center;
        }

        .tabla-multas th {
            background-color: #343a40;
            color: white;
        }

        .tabla-multas td {
            background-color: #f8f9fa;
        }

        .monto {
            color: #28a745;
        }

        .no-resultados {
            text-align: center;
            font-size: 18px;
            color:rgb(36, 0, 240);
        }

        .btn-volver {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
        }

        .btn-volver:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Reporte de Adeudos</h2>
        
        <?php if ($resultado->num_rows > 0): ?>
            <table class="tabla-multas table table-bordered table-striped mt-4">
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
       
</body>
</html>
