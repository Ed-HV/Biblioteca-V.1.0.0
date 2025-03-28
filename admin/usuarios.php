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
    <!-- Incluir el CDN de Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-4">
        <h2 class="text-center mb-4">Lista de Usuarios</h2>

        <table class="table table-bordered table-striped table-hover">
            <thead class="thead-dark">
                <tr>
                    <th class="text-center">ID</th>
                    <th class="text-center">Nombre</th>
                    <th class="text-center">Tipo Usuario</th>
                    <th class="text-center">Matrícula</th>
                    <th class="text-center">Nivel Educativo</th>
                    <th class="text-center">Email</th>
                    <th class="text-center">Teléfono</th>
                    <th class="text-center">Saldo</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($fila = $resultado->fetch_assoc()) { ?>
                <tr>
                    <td class="text-center"><?php echo $fila['id_usuario']; ?></td>
                    <td class="text-center"><?php echo $fila['nombre']; ?></td>
                    <td class="text-center"><?php echo $fila['tipo_usuario']; ?></td>
                    <td class="text-center"><?php echo $fila['matricula_credencial']; ?></td>
                    <td class="text-center"><?php echo $fila['nivel_educativo']; ?></td>
                    <td class="text-center"><?php echo $fila['email']; ?></td>
                    <td class="text-center"><?php echo $fila['telefono']; ?></td>
                    <td class="text-center"><?php echo "$" . number_format($fila['saldo'], 2); ?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
