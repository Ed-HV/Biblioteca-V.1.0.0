<?php
include 'conexion.php'; // Incluye la conexión a la base de datos

$query = "SELECT * FROM usuarios";
$resultado = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Usuarios</title>
    <link rel="stylesheet" href="assets/css/usuarioStyle.css">  
</head>
<body>
    <h2>Lista de Usuarios</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Tipo Usuario</th>
            <th>Matrícula</th>
            <th>Nivel Educativo</th>
            <th>Email</th>
            <th>Teléfono</th>
            <th>Saldo</th>
        </tr>
        <?php while ($fila = $resultado->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $fila['id_usuario']; ?></td>
            <td><?php echo $fila['nombre']; ?></td>
            <td><?php echo $fila['tipo_usuario']; ?></td>
            <td><?php echo $fila['matricula_credencial']; ?></td>
            <td><?php echo $fila['nivel_educativo']; ?></td>
            <td><?php echo $fila['email']; ?></td>
            <td><?php echo $fila['telefono']; ?></td>
            <td><?php echo "$" . number_format($fila['saldo'], 2); ?></td>
        </tr>
        <?php } ?>
    </table>
</body>
</html>
