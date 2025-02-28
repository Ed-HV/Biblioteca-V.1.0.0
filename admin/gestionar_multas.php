<?php
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_multa = $_POST['id_multa'];

    // Llamada al procedimiento almacenado para pagar la multa
    $sql = "CALL pagar_multa('$id_multa')";

    if ($conn->query($sql) === TRUE) {
        echo "Multa pagada exitosamente.";
    } else {
        echo "Error al pagar multa: " . $conn->error;
    }
}
?>

<!-- Formulario para pagar multa -->
<form method="POST" action="gestionar_multas.php">
    ID de la Multa: <input type="number" name="id_multa" required><br>
    <input type="submit" value="Pagar Multa">
</form>

