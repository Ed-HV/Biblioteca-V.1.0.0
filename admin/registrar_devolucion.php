<?php
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_prestamo = $_POST['id_prestamo'];

    // Llamada al procedimiento almacenado para devolver el libro
    $sql = "CALL registrar_devolucion('$id_prestamo')";

    if ($conn->query($sql) === TRUE) {
        echo "Devolución registrada exitosamente.";
    } else {
        echo "Error al registrar devolución: " . $conn->error;
    }
}
?>

<!-- Formulario para registrar devolución -->
<form method="POST" action="registrar_devolucion.php">
    ID del Préstamo: <input type="number" name="id_prestamo" required><br>
    <input type="submit" value="Registrar Devolución">
</form>

