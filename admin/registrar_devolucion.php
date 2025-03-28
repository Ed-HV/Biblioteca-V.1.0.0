<?php
include 'conexion.php';

$mensaje="";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_prestamo = $_POST['id_prestamo'];  // ID del préstamo

    // Llamada al procedimiento almacenado para registrar la devolución
    $sql = "CALL registrar_devolucion(?, @mensaje)";

    $stmt = $conn->prepare($sql);
    
    if ($stmt) {
        // Vincula los parámetros
        $stmt->bind_param("i", $id_prestamo);
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

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Devolución</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .form-container {
            background:white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            margin: 50px auto; /* Centrado sin afectar el cuerpo */
        }

        .form-container h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .form-container input[type="number"],
        .form-container input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .form-container input[type="submit"] {
            background-color: #007bff;
            color: white;
            cursor: pointer;
        }

        .form-container input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

    <!-- Contenedor del formulario centrado -->
    <div class="form-container">
        <h2>Registrar Devolución</h2>
        <form method="POST" action="dashboard.php?modulo=registrar_devolucion">
            <label for="id_prestamo">ID del Préstamo:</label>
            <input type="number" name="id_prestamo" required>
            <input type="submit" value="Registrar Devolución">
        </form>
    </div>

</body>
</html>
