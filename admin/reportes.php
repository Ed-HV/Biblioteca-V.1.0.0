<?php
include 'conexion.php';

// Reporte de libros prestados
$sql = "SELECT p.id_prestamo, u.nombre AS usuario, l.titulo AS libro, p.fecha_prestamo, p.fecha_devolucion 
        FROM prestamos p
        JOIN usuarios u ON p.id_usuario = u.id_usuario
        JOIN libros l ON p.id_libro = l.id_libro
        WHERE p.estado_prestamo = 'Activo'";

$result = $conn->query($sql);

echo "<h2>Libros Prestados</h2>";
if ($result->num_rows > 0) {
    echo "<table border='1'><tr><th>ID Préstamo</th><th>Usuario</th><th>Libro</th><th>Fecha Préstamo</th><th>Fecha Devolución</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row['id_prestamo'] . "</td><td>" . $row['usuario'] . "</td><td>" . $row['libro'] . "</td><td>" . $row['fecha_prestamo'] . "</td><td>" . $row['fecha_devolucion'] . "</td></tr>";
    }
    echo "</table>";
} else {
    echo "No hay préstamos activos.";
}
?>

