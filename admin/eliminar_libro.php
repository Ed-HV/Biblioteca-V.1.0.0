<?php
include 'conexion.php';

// Verificar si se pasó un ID para eliminar
if (isset($_GET['id_libro'])) {
    $id_libro = $_GET['id_libro'];

    // Verificar si el libro está prestado antes de eliminarlo
    $verificar = "SELECT * FROM prestamos WHERE id_libro = '$id_libro' AND estado_prestamo = 'Activo'";
    $resultado = $conn->query($verificar);

    if ($resultado->num_rows > 0) {
        echo "No se puede eliminar el libro porque está prestado actualmente.";
    } else {
        // Eliminar el libro
        $sql = "DELETE FROM libros WHERE id_libro = '$id_libro'";

        if ($conn->query($sql) === TRUE) {
            echo "Libro eliminado exitosamente.";
        } else {
            echo "Error al eliminar libro: " . $conn->error;
        }
    }
} else {
    echo "ID del libro no proporcionado.";
}
?>

<!-- Enlace para volver a la gestión de libros -->
<br>
<a href="agregar_libro.php">Volver a la Gestión de Libros</a>

