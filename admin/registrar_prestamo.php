<?php
include 'conexion.php';
$mensaje = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validar y sanitizar la entrada
    $id_usuario = filter_input(INPUT_POST, 'id_usuario', FILTER_VALIDATE_INT);
    $id_libro = filter_input(INPUT_POST, 'id_libro', FILTER_VALIDATE_INT);

    if ($id_usuario === false || $id_libro === false) {
        $mensaje = "Datos inválidos. Introduzca valores numéricos.";
    } else {
        // Definir la consulta para llamar al procedimiento almacenado
        $sql = "CALL registrar_prestamo(?, ?, @mensaje)";
        
        // Preparar la consulta
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $id_usuario, $id_libro);

        if ($stmt->execute()) {
            // Obtener el mensaje de salida
            $resultado = $conn->query("SELECT @mensaje AS mensaje");
            $fila = $resultado->fetch_assoc();
            $mensaje = $fila['mensaje'];
        } else {
            $mensaje = "Error al registrar préstamo: " . $stmt->error;
        }

        // Cerrar statement y conexión
        $stmt->close();
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Préstamo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?php if (!empty($mensaje)): ?>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            alert("<?php echo addslashes($mensaje); ?>");
        });
    </script>
<?php endif; ?>

<div class="container d-flex justify-content-center align-items-center min-vh-50">
    <div class="col-md-6">
        <div class="card shadow-lg">
            <div class="card-body text-center">
                <h3 class="mb-4">Registrar Préstamo</h3>
                <form method="POST" action="dashboard.php?modulo=registrar_prestamo">
                    <div class="mb-3">
                        <label for="id_usuario" class="form-label">ID del Usuario</label>
                        <input type="number" name="id_usuario" id="id_usuario" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="id_libro" class="form-label">ID del Libro</label>
                        <input type="number" name="id_libro" id="id_libro" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Registrar Préstamo</button>
                </form>
                <br>
                <a href="dashboard.php?modulo=agregar_libro" class="btn btn-secondary w-100">Volver a Gestión de Préstamos</a>
            </div>
        </div>
    </div>
</div>

</body>
</html>
