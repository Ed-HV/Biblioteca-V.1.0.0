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
    <title>Lista de Usuarios</title>
    <link rel="stylesheet" href="assets/css/fechaStyle.css">  
</head>
<body>
  
<h2>Próximas Fechas de Entrega</h2>
<table>
    <tr>
        <th>ID Préstamo</th>
        <th>Usuario</th>
        <th>Libro</th>
        <th>Fecha de Devolución</th>
    </tr>
    <?php while ($fila = $resultado->fetch_assoc()) { ?>
    <tr>
        <td><?php echo $fila['id_prestamo']; ?></td>
        <td><?php echo $fila['nombre']; ?></td>
        <td><?php echo $fila['titulo']; ?></td>
        <td><?php echo $fila['fecha_devolucion']; ?></td>
    </tr>
    <?php } ?>
</table>
