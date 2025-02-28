<?php
include 'conexion.php';
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['id_usuario'])) {
    header('Location: login.php');
    exit();
}

// Procesar el formulario al enviarlo
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id_prestamo'])) {
    // Obtener el id_prestamo enviado desde el formulario
    $id_prestamo = $_POST['id_prestamo'];

    // Verificar que el préstamo existe y pertenece al usuario
    $sql = "SELECT renovaciones, fecha_devolucion FROM prestamos WHERE id_prestamo = '$id_prestamo' AND id_usuario = '" . $_SESSION['id_usuario'] . "'";
    $result = $conn->query($sql);

    // Si no se encuentra el préstamo, mostrar un mensaje de error
    if ($result->num_rows == 0) {
        echo "<p class='text-danger'>Error: No se encontró el préstamo para renovar.</p>";
    } else {
        // Obtener los datos del préstamo
        $prestamo = $result->fetch_assoc();

        // Verificar si el préstamo puede renovarse (máximo 3 renovaciones)
        if ($prestamo['renovaciones'] < 3) {
            // Actualizar la fecha de devolución y el número de renovaciones
            $sql = "UPDATE prestamos 
                    SET fecha_devolucion = DATE_ADD(fecha_devolucion, INTERVAL 4 DAY), 
                        renovaciones = renovaciones + 1 
                    WHERE id_prestamo = '$id_prestamo'";
            
            if ($conn->query($sql) === TRUE) {
                // Calcular la nueva fecha de devolución para mostrarla al usuario
                $nueva_fecha = date('Y-m-d', strtotime($prestamo['fecha_devolucion'] . ' +4 days'));
                // Mostrar mensaje emergente y mensaje en la página
                echo "<script>alert('Préstamo renovado exitosamente');</script>";
                echo "<p class='text-success'>Préstamo renovado exitosamente. Nueva fecha de devolución: $nueva_fecha</p>";
            } else {
                echo "<p class='text-danger'>Error al renovar préstamo: " . $conn->error . "</p>";
            }
        } else {
            echo "<p class='text-warning'>No puedes renovar este préstamo más de 3 veces. Debes esperar 2 semanas para volver a solicitarlo.</p>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Renovar Préstamo</title>
    <!-- Bootstrap 5 CSS -->
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
     <link rel="stylesheet" href="assets\css\renovarStyle.css"> 
 
</head>
<body>
    <h2>Renovar Préstamo</h2>
    <form method="post" action="">
        <label for="id_prestamo">Ingrese el ID del préstamo:</label>
        <input type="text" name="id_prestamo" id="id_prestamo" required>
        <button type="submit">Renovar Préstamo</button>
    </form>
    <br>
    <a href="mis_prestamos.php" class="btn btn-primary mt-3">Volver a Mis Préstamos</a>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
