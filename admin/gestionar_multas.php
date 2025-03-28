<?php
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['id_multa']) && is_numeric($_POST['id_multa'])) {
        $id_multa = $_POST['id_multa'];

        // Llamar al procedimiento almacenado para pagar la multa
        $sql = "CALL pagar_multa(?)";
        if ($stmt = $conn->prepare($sql)) {
            // Vincular el parámetro
            $stmt->bind_param("i", $id_multa);

            // Ejecutar la consulta
            if ($stmt->execute()) {
                // Obtener el mensaje de salida del procedimiento
                $result = $stmt->get_result();
                if ($result) {
                    $row = $result->fetch_assoc();
                    $mensaje = $row['mensaje'] ?? 'Proceso completado.';
                } else {
                    $mensaje = 'Error: No se obtuvo el mensaje de la base de datos.';
                }

                // Usar SweetAlert para mostrar el mensaje
                echo "<script>
                        document.addEventListener('DOMContentLoaded', function() {
                            Swal.fire({
                                title: 'Información',
                                text: '$mensaje',
                                icon: 'info',
                                confirmButtonText: 'OK'
                            }).then(() => {
                                window.location = 'dashboard.php?modulo=gestionar_multas'; // Redirigir después de pagar
                            });
                        });
                      </script>";
            } else {
                // Error al ejecutar la consulta
                echo "<script>
                        Swal.fire('Error', 'No se pudo ejecutar la consulta.', 'error');
                      </script>";
            }

            // Cerrar la consulta
            $stmt->close();
        } else {
            // Error en la preparación de la consulta
            echo "<script>
                    Swal.fire('Error', 'Error en la preparación de la consulta.', 'error');
                  </script>";
        }
    } else {
        // ID de multa no válido
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
    <!-- Agregar el CDN de Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <style>
        .contenedor {
            display: flex;
            justify-content: center;
            text-align: center;
        }
        .contenido {
            background: white;
            padding: 50px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>

<div class="contenedor">
    <div class="contenido">
        <h2>Pagar Multa</h2>
        <form method="POST" action="dashboard.php?modulo=gestionar_multas">
            <div class="mb-3">
                <label for="id_multa" class="form-label">ID de la Multa:</label>
                <input type="number" name="id_multa" id="id_multa" class="form-control" required>
            </div>
            <!-- Botón azul con Bootstrap -->
            <button type="submit" class="btn btn-primary">Pagar Multa</button>
        </form>
    </div>
</div>

</body>
</html>
