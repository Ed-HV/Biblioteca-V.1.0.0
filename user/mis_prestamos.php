<?php
include 'conexion.php';
session_start();

if (!isset($_SESSION['id_usuario'])) {
    header('Location: login.php');
    exit();
}

$id_usuario = $_SESSION['id_usuario'];

// Registrar un préstamo si se seleccionó un libro
if (isset($_GET['id_libro'])) {
    $id_libro = $_GET['id_libro'];

    // Llamar al procedimiento almacenado para registrar el préstamo
    $sql = "CALL registrar_prestamo('$id_usuario', '$id_libro')";
    if ($conn->query($sql) === TRUE) {
        echo "Préstamo registrado exitosamente.";
    } else {
        echo "Error al registrar préstamo: " . $conn->error;
    }
}

// Mostrar préstamos activos del usuario
$sql = "SELECT p.id_prestamo, l.titulo, p.fecha_prestamo, p.fecha_devolucion, p.renovaciones 
        FROM prestamos p
        JOIN libros l ON p.id_libro = l.id_libro
        WHERE p.id_usuario = '$id_usuario' AND p.estado_prestamo = 'Activo'";
$result = $conn->query($sql);
?>

<h2>Mis Préstamos</h2>
<?php
if ($result->num_rows > 0) {
    echo "<table border='1'><tr><th>Título</th><th>Fecha Préstamo</th><th>Fecha Devolución</th><th>Renovaciones</th><th>Acción</th></tr>";
    while ($prestamo = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . $prestamo['titulo'] . "</td>
                <td>" . $prestamo['fecha_prestamo'] . "</td>
                <td>" . $prestamo['fecha_devolucion'] . "</td>
                <td>" . $prestamo['renovaciones'] . "</td>
                <td><a href='renovar_prestamo.php?id_prestamo=" . $prestamo['id_prestamo'] . "'>Renovar</a></td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "No tienes préstamos activos.";
}
?>
<head>
    <meta charset="UTF-8">
    <title>Mis Préstamos</title>
    <link rel="stylesheet" href="assets\css\prestamoStyle.css">
</head>

