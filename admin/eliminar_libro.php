<?php
include 'conexion.php';

// Inicializar el mensaje
$mensaje = "";

// Procesar el formulario cuando se envíe
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id_libro'])) {
    $id_libro = $_POST['id_libro'];

    // Verificar si el libro está prestado antes de eliminarlo
    $verificar = "SELECT * FROM prestamos WHERE id_libro = '$id_libro' AND estado_prestamo = 'Activo'";
    $resultado = $conn->query($verificar);

    if ($resultado->num_rows > 0) {
        $mensaje = "⚠️ No se puede eliminar el libro porque está prestado actualmente.";
        $icono = "warning";
    } else {
        // Eliminar los préstamos asociados primero
        $eliminar_prestamos = "DELETE FROM prestamos WHERE id_libro = '$id_libro'";
        $conn->query($eliminar_prestamos);

        // Eliminar el libro
        $sql = "DELETE FROM libros WHERE id_libro = '$id_libro'";

        if ($conn->query($sql) === TRUE) {
            $mensaje = "✅ Libro eliminado exitosamente.";
            $icono = "success";
        } else {
            $mensaje = "⚠️ Error al eliminar libro: " . addslashes($conn->error);
            $icono = "error";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar Libro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

<?php if (!empty($mensaje)): ?>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            Swal.fire({
                title: 'Información',
                text: '<?php echo $mensaje; ?>',
                icon: '<?php echo $icono; ?>',
                confirmButtonText: 'OK'
            });
        });
    </script>
<?php endif; ?>

<!-- Formulario centrado -->
<div class="container d-flex justify-content-center align-items-center min-vh-50">
    <div class="col-md-6">
        <div class="card shadow-lg">
            <div class="card-body text-center">
                <h3 class="mb-4">Eliminar Libro</h3>
                <form method="POST" action="dashboard.php?modulo=eliminar_libro">
                    <div class="mb-3">
                        <label for="id_libro" class="form-label">ID del Libro a Eliminar</label>
                        <input type="number" name="id_libro" id="id_libro" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-danger w-100">Eliminar Libro</button>
                </form>
                <br>
                <a href="dashboard.php?modulo=agregar_libro" class="btn btn-secondary w-100">Volver a la Gestión de Libros</a>
            </div>
        </div>
    </div>
</div>

</body>
</html>
