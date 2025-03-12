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
        $mensaje = "No se puede eliminar el libro porque está prestado actualmente.";
    } else {
        // Eliminar los préstamos asociados primero
        $eliminar_prestamos = "DELETE FROM prestamos WHERE id_libro = '$id_libro'";
        $conn->query($eliminar_prestamos);

        // Eliminar el libro
        $sql = "DELETE FROM libros WHERE id_libro = '$id_libro'";

        if ($conn->query($sql) === TRUE) {
            $mensaje = "Libro eliminado exitosamente.";
        } else {
            $mensaje = "Error al eliminar libro: " . $conn->error;
        }
    }
}
?>

<!-- Mostrar mensaje si existe -->
<?php if (!empty($mensaje)): ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                title: 'Información',
                text: '<?php echo $mensaje; ?>',
                icon: 'info',
                confirmButtonText: 'OK'
            });
        });
    </script>
<?php endif; ?>

<!-- Formulario para ingresar el ID del libro a eliminar -->
<form method="POST" action="dashboard.php?modulo=eliminar_libro">
    <label for="id_libro">ID del Libro a Eliminar:</label>
    <input type="number" name="id_libro" id="id_libro" required><br>
    <input type="submit" value="Eliminar Libro">
</form>

<!-- Enlace para volver a la gestión de libros -->
<br>
<a href="dashboard.php?modulo=agregar_libro">Volver a la Gestión de Libros</a>

<!-- Incluir el script de SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
