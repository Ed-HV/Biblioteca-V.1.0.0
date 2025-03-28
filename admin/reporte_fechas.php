<?php
include 'conexion.php';

$query = "SELECT p.id_prestamo, u.nombre, l.titulo, p.fecha_devolucion 
          FROM prestamos p
          JOIN usuarios u ON p.id_usuario = u.id_usuario
          JOIN libros l ON p.id_libro = l.id_libro
          WHERE p.fecha_devolucion BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 7 DAY)
          AND p.estado_prestamo = 'Activo'
          ORDER BY p.fecha_devolucion ASC";

$resultado = $conn->query($query);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Próximas Fechas de Entrega</title>
    <!-- Agregar el CDN de Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body>

<div class="container my-5">
    <h2 class="text-center mb-4">Próximas Fechas de Entrega</h2>

    <table class="table table-bordered table-striped table-hover">
        <thead class="thead-dark">
            <tr>
                <th>ID Préstamo</th>
                <th>Usuario</th>
                <th>Libro</th>
                <th>Fecha de Devolución</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($fila = $resultado->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $fila['id_prestamo']; ?></td>
                    <td><?php echo $fila['nombre']; ?></td>
                    <td><?php echo $fila['titulo']; ?></td>
                    <td style="color: red;"><?php echo $fila['fecha_devolucion']; ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

</body>
</html>
