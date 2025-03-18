<?php
include 'conexion.php';
session();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_usuario = $_POST['id_usuario'];
    $id_libro = $_POST['id_libro'];

    // Llamada al procedimiento almacenado
    $sql = "CALL registrar_prestamo('$id_usuario', '$id_libro')";

    if ($conn->query($sql) === TRUE) {
        echo "Préstamo registrado exitosamente.";
    } else {
        echo "Error al registrar préstamo: " . $conn->error;
    }
}
?>

<!-- Formulario para registrar préstamo -->
<form method="POST" action="registrar_prestamo.php">
    ID del Usuario: <input type="number" name="id_usuario" required><br>
    ID del Libro: <input type="number" name="id_libro" required><br>
    <input type="submit" value="Registrar Préstamo">
</form>

