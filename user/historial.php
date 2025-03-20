<?php
include 'conexion.php';
session_start();

if (!isset($_SESSION['id_usuario'])) {
    header('Location: login.php');
    exit();
}

$id_usuario = $_SESSION['id_usuario'];

$sql = "SELECT l.titulo, p.fecha_prestamo, p.fecha_devolucion, p.estado_prestamo 
        FROM prestamos p
        JOIN libros l ON p.id_libro = l.id_libro
        WHERE p.id_usuario = '$id_usuario'";
$result = $conn->query($sql);
?>

<h2>Historial de Préstamos</h2>
<?php
if ($result->num_rows > 0) {
    echo "<table class='tabla-neon'>";

    /*echo "<table border='1'><tr><th>Título</th><th>Fecha Préstamo</th><th>Fecha Devolución</th><th>Estado</th></tr>";*/
    while ($prestamo = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . $prestamo['titulo'] . "</td>
                <td>" . $prestamo['fecha_prestamo'] . "</td>
                <td>" . $prestamo['fecha_devolucion'] . "</td>
                <td>" . $prestamo['estado_prestamo'] . "</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "No tienes historial de préstamos.";
}
?>
 

<head>
    <meta charset="UTF-8">
    <title>Historial de Prestamos</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets\css\historialStyle.css">
</head>

