<?php
include  'conexion.php';

$query = "SELECT m.id_multa, u.nombre, m.multa_pendiente, m.fecha_registro 
          FROM multas m
          JOIN usuarios u ON m.id_usuario = u.id_usuario
          WHERE m.pagado = 0
          ORDER BY m.fecha_registro ASC";

$resultado = $conn->query($query);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Usuarios</title>
    <link rel="stylesheet" href="assets/css/adeudoStyle.css">  
</head>
<h2>Reporte de Adeudos</h2>
<table>
    <tr>
        <th>ID Multa</th>
        <th>Usuario</th>
        <th>Monto Pendiente</th>
        <th>Fecha de Registro</th>
    </tr>
    <?php while ($fila = $resultado->fetch_assoc()) { ?>
    <tr>
        <td><?php echo $fila['id_multa']; ?></td>
        <td><?php echo $fila['nombre']; ?></td>
        <td><?php echo "$" . number_format($fila['multa_pendiente'], 2); ?></td>
        <td><?php echo $fila['fecha_registro']; ?></td>
    </tr>
    <?php } ?>
</table>
