<?php
include 'conexion.php';
$mensaje="";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validar y sanitizar la entrada
    $id_usuario = filter_input(INPUT_POST, 'id_usuario', FILTER_VALIDATE_INT);
    $id_libro = filter_input(INPUT_POST, 'id_libro', FILTER_VALIDATE_INT);

    if ($id_usuario === false || $id_libro === false) {
        echo "Datos inválidos. Introduzca valores numéricos.";
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
            echo "Resultado: " . $fila['mensaje'];
        } else {
            echo "Error al registrar préstamo: " . $stmt->error;
        }

        // Cerrar statement y conexión
        $stmt->close();
    }
    $conn->close();
}
?>

<!-- Formulario para registrar préstamo -->
<form method="POST" action="dashboard.php?modulo=registrar_prestamo">
    ID del Usuario: <input type="number" name="id_usuario" required><br>
    ID del Libro: <input type="number" name="id_libro" required><br>
    <input type="submit" value="Registrar Préstamo">
</form>
