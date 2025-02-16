<?php
include 'conexion.php';
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['id_usuario'])) {
    header('Location: login.php');
    exit();
}

// Verificar si se recibió el id_prestamo en la URL
if (!isset($_GET['id_prestamo'])) {
    echo "<p class='text-danger'>Error: No se especificó el préstamo a renovar.</p>";
    exit();
}

$id_prestamo = $_GET['id_prestamo'];

// Verificar que el préstamo existe y pertenece al usuario
$sql = "SELECT renovaciones, fecha_devolucion FROM prestamos WHERE id_prestamo = '$id_prestamo' AND id_usuario = '" . $_SESSION['id_usuario'] . "'";
$result = $conn->query($sql);

// Si no se encuentra el préstamo, mostrar un mensaje de error
if ($result->num_rows == 0) {
    echo "<p class='text-danger'>Error: No se encontró el préstamo para renovar.</p>";
    exit();
}

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
        echo "<p class='text-success'>Préstamo renovado exitosamente. Nueva fecha de devolución: " . date('Y-m-d', strtotime($prestamo['fecha_devolucion'] . ' +4 days')) . "</p>";
    } else {
        echo "<p class='text-danger'>Error al renovar préstamo: " . $conn->error . "</p>";
    }
} else {
    echo "<p class='text-warning'>No puedes renovar este préstamo más de 3 veces. Debes esperar 2 semanas para volver a solicitarlo.</p>";
}
?>
<br>
<a href="mis_prestamos.php" type=submit class="btn btn-primary mt-3">Volver a Mis Préstamos</a>
