<?php
include 'conexion.php';
session_start();
// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['id_usuario'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_prestamo = $_POST['id_prestamo'];  // ID del préstamo
    $id_usuario = $_SESSION['id_usuario'];  // Suponiendo que el ID del usuario está en la sesión

    // Llamada al procedimiento almacenado para registrar la devolución
    $sql = "CALL registrar_devolucion(?, ?, @mensaje)";
    $stmt = $conn->prepare($sql);
    
    if ($stmt) {
        // Vincula los parámetros
        $stmt->bind_param("ii", $id_prestamo, $id_usuario);
        $stmt->execute();
        $stmt->close();

        // Obtener el mensaje de la variable de salida
        $sql_mensaje = "SELECT @mensaje AS mensaje";
        $result = $conn->query($sql_mensaje);
        if ($result) {
            $mensaje = $result->fetch_assoc()['mensaje'];
            echo $mensaje;  // Muestra el mensaje generado por el procedimiento almacenado
        } else {
            echo "Error al obtener el mensaje: " . $conn->error;
        }
    } else {
        echo "Error al registrar la devolución: " . $conn->error;
    }
}

if (!empty($mensaje)) {
    echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: 'Información',
                    text: '$mensaje',
                    icon: 'info',
                    confirmButtonText: 'OK'
                }).then(() => {
                    window.location = 'dashboard.php?modulo=registrar_devolucion';
                });
            });
          </script>";
}

?>

<div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</div>

<!-- Formulario para registrar devolución -->
<form method="POST" action="registrar_devolucion.php">
    ID del Préstamo: <input type="number" name="id_prestamo" required><br>
    <input type="submit" value="Registrar Devolución">
</form>
