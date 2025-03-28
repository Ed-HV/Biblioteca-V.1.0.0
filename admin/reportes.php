<?php
include 'conexion.php';

// Reporte de libros prestados
$sql = "SELECT p.id_prestamo, u.nombre AS usuario, l.titulo AS libro, p.fecha_prestamo, p.fecha_devolucion 
        FROM prestamos p
        JOIN usuarios u ON p.id_usuario = u.id_usuario
        JOIN libros l ON p.id_libro = l.id_libro
        WHERE p.estado_prestamo = 'Activo'";

$result = $conn->query($sql);



// Incluir el CDN de Bootstrap
echo '<link href="https://cdn.jsdelivr.net/nm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet">';
echo "<h2 class='text-center mb-4'>Libros Prestados Actualmente</h2>";
if ($result->num_rows > 1) {
    echo "<table class='table table-bordered table-striped'>";
    echo "<thead class='thead-dark'>
            <tr>
                <th>ID Préstamo</th>
                <th>Usuario</th>
                <th>Libro</th>
                <th>Fecha Préstamo</th>
                <th>Fecha Devolución</th>
            </tr>
          </thead>
          <tbody>";
    
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . $row['id_prestamo'] . "</td>
                <td>" . $row['usuario'] . "</td>
                <td>" . $row['libro'] . "</td>
                <td>" . $row['fecha_prestamo'] . "</td>
                <td>" . $row['fecha_devolucion'] . "</td>
              </tr>";
    }
    echo "</tbody></table>";
} else {
    echo "No hay préstamos activos.";
}
?>
