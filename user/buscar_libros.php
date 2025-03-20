<?php
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $busqueda = $_POST['busqueda'];
    $sql = "SELECT libros.*, 
                   (SELECT MIN(fecha_devolucion) 
                    FROM prestamos 
                    WHERE prestamos.id_libro = libros.id_libro 
                      AND prestamos.estado_prestamo = 'Activo') AS fecha_disponible
            FROM libros 
            WHERE (titulo LIKE ? OR autor LIKE ? OR isbn LIKE ? OR id_libro LIKE ?)";
    $stmt = $conn->prepare($sql);
    $searchTerm = "%$busqueda%";
    $stmt->bind_param("ssss", $searchTerm, $searchTerm, $searchTerm, $searchTerm);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $sql = "SELECT libros.*, 
                   (SELECT MIN(fecha_devolucion) 
                    FROM prestamos 
                    WHERE prestamos.id_libro = libros.id_libro 
                      AND prestamos.estado_prestamo = 'Activo') AS fecha_disponible
            FROM libros";
    $result = $conn->query($sql);
}
?>

<!DOCTYPE html>
<html>  
    <head>
        <title>Biblioteca</title>
        <link rel="stylesheet" type="text/css" href="assets/css/buscarStyle.css">
    </head>
    <body>
        <form method="POST" action="buscar_libros.php">
            Buscar libro: <input type="text" name="busqueda" placeholder="Título, autor, ID o ISBN">
            <input type="submit" value="Buscar">
        </form>

        <h3>Libros Disponibles:</h3>
        <?php
        if ($result->num_rows > 0) {
            echo "<table border='1'><tr><th>ISBN</th><th>Título</th><th>Autor</th><th>Estado</th><th>Acción</th><th>En Inventario</th><th>Disponible A partir de</th></tr>";
            while ($libro = $result->fetch_assoc()) {
                echo "<tr>
                        <td>" . htmlspecialchars($libro['isbn']) . "</td>
                        <td>" . htmlspecialchars($libro['titulo']) . "</td>
                        <td>" . htmlspecialchars($libro['autor']) . "</td>
                        <td>" . htmlspecialchars($libro['estado']) . "</td>
                        <td>";
                if ($libro['estado'] == 'Disponible') {
                    echo "<a href='mis_prestamos.php?id_libro=" . $libro['id_libro'] . "'>Solicitar Préstamo</a>";
                } else {
                    echo "No disponible";
                }
                echo "</td>
                        <td>" . htmlspecialchars($libro['disponibilidad']) . "</td>
                        <td>";
                // Mostrar fecha disponible solo si el libro no está disponible
                if ($libro['estado'] != 'Disponible') {
                    echo $libro['fecha_disponible'] ? htmlspecialchars($libro['fecha_disponible']) : 'N/A';
                } else {
                    echo "Disponible ahora";
                }
                echo "</td>
                      </tr>";
            }
            echo "</table>";
        } else {
            echo "No se encontraron libros disponibles.";
        }
        ?>
        <form method="POST" action="dashboard.php">
            <button type="submit" class="btn btn-success w-100">Dashboard</button>    
        </form>
    </body>
</html>