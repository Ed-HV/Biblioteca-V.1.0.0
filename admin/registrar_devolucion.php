<?php
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_prestamo = $_POST['id_prestamo']; // ID del préstamo

    // Activar excepciones en caso de error con MySQLi
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    try {
        // Llamada al procedimiento almacenado para registrar la devolución
        $sql = "CALL registrar_devolucion(?, @mensaje)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id_prestamo);
        $stmt->execute();
        $stmt->close();

        // Obtener el mensaje de salida del procedimiento
        $result = $conn->query("SELECT @mensaje AS mensaje");
        $mensaje = $result->fetch_assoc()['mensaje'];

    } catch (Exception $e) {
        $mensaje = "Error al registrar la devolución: " . $e->getMessage();
    }
}
?>

<!-- Si hay mensaje, mostrar SweetAlert y redireccionar -->
<?php if (!empty($mensaje)): ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                title: 'Información',
                text: '<?= $mensaje ?>',
                icon: 'info',
                confirmButtonText: 'OK'
            }).then(() => {
                window.location = 'dashboard.php?modulo=registrar_devolucion';
            });
        });
    </script>
<?php endif; ?>

<!-- Formulario para registrar devolución -->
<form method="POST" action="registrar_devolucion.php">
    ID del Préstamo: <input type="number" name="id_prestamo" required><br>
    <input type="submit" value="Registrar Devolución">
</form>
