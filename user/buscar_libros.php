<?php
include 'conexion.php';
session_start();

// Verifica que el usuario haya iniciado sesión
if (!isset($_SESSION['id_usuario'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $busqueda = $_POST['busqueda'];
    $sql = "SELECT * FROM libros 
            WHERE (titulo LIKE '%$busqueda%' OR autor LIKE '%$busqueda%' OR isbn LIKE '%$busqueda%'  OR id_libro LIKE '%$busqueda%') 
            AND estado = 'Disponible'";
    $result = $conn->query($sql);
} else {
    $result = $conn->query("SELECT * FROM libros WHERE estado = 'Disponible'");
}
?>

<!DOCTYPE html>
<html>  
    <head>
        <title>Biblioteca</title>
        <link rel="stylesheet" type="text/css" href="assets\css\buscarStyle.css">
        </head>

<form method="POST" action="buscar_libros.php">
    Buscar libro: <input type="text" name="busqueda" placeholder="Título, autor, ID o ISBN">
    <input type="submit" value="Buscar">
</form>

<h3>Libros Disponibles:</h3>
<?php
if ($result->num_rows > 0) {
    echo "<table border='1'><tr><th>ISBN</th><th>Título</th><th>Autor</th><th>Estado</th><th>Acción</th><th>En Inventario</th><th>Disponible Apartir</th></tr>";
    while ($libro = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . $libro['isbn'] . "</td>
                <td>" . $libro['titulo'] . "</td>
                <td>" . $libro['autor'] . "</td>
                <td>" . $libro['estado'] . "</td>
                <td><a href='mis_prestamos.php?id_libro=" . $libro['id_libro'] . "'>Solicitar Préstamo</a></td>
                <td>" . $libro['disponibilidad'] . "</td>
                 <td>" . $libro['fecha_disponible'] . "</td>
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