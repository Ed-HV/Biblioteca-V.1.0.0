<?php
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['id_multa']) && is_numeric($_POST['id_multa'])) {
        $id_multa = $_POST['id_multa'];

        // Llamar al procedimiento almacenado para pagar la multa
        $sql = "CALL pagar_multa(?)";
        $stmt = $conn->prepare($sql);
        
        if ($stmt) {
            $stmt->bind_param("i", $id_multa);
            if ($stmt->execute()) {
                // Obtener el mensaje de salida del procedimiento
                $result = $stmt->get_result();
                $row = $result->fetch_assoc();
                $mensaje = $row['mensaje'] ?? 'Proceso completado.';

                echo "<script>
                        document.addEventListener('DOMContentLoaded', function() {
                            Swal.fire({
                                title: 'Información',
                                text: '$mensaje',
                                icon: 'info',
                                confirmButtonText: 'OK'
                            }).then(() => {
                                window.location = 'gestionar_multas.php';
                            });
                        });
                      </script>";
            } else {
                echo "<script>
                        Swal.fire('Error', 'No se pudo ejecutar la consulta.', 'error');
                      </script>";
            }
            $stmt->close();
        } else {
            echo "<script>
                    Swal.fire('Error', 'Error en la preparación de la consulta.', 'error');
                  </script>";
        }
    } else {
        echo "<script>
                Swal.fire('Advertencia', 'ID de multa inválido.', 'warning');
              </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestionar Multas</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

<h2>Pagar Multa</h2>

<form method="POST" action="dashboard.php?modulo=gestionar_multas">
    <label for="id_multa">ID de la Multa:</label>
    <input type="number" name="id_multa" id="id_multa" required><br><br>
    <input type="submit" value="Pagar Multa">
</form>

</body>
</html>
