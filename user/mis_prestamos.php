<?php
include 'conexion.php';
session_start();

if (!isset($_SESSION['id_usuario'])) {
    header('Location: login.php');
    exit();
}

$id_usuario = $_SESSION['id_usuario'];
$mensaje = "";

// Llamar al procedimiento para calcular multas antes de cualquier operación
$conn->query("CALL calcular_multas_por_retraso()");

// Si se seleccionó un libro para préstamo
if (isset($_GET['id_libro'])) {
    $id_libro = $_GET['id_libro'];

    // Llamar al procedimiento almacenado y obtener el mensaje de salida
    $sql = "CALL registrar_prestamo(?, ?, @mensaje)";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("ii", $id_usuario, $id_libro);
        $stmt->execute();
        $stmt->close();

        // Obtener el mensaje resultante
        $result = $conn->query("SELECT @mensaje AS mensaje");
        if ($row = $result->fetch_assoc()) {
            $mensaje = $row['mensaje'];
        }
    } else {
        $mensaje = "❌ Error al ejecutar el procedimiento de préstamo.";
    }
}

// Consultar préstamos activos del usuario, incluyendo la multa real
$sql = "SELECT p.id_prestamo, l.titulo, p.fecha_prestamo, p.fecha_devolucion, 
               p.renovaciones, p.estado_prestamo, p.deposito, p.multa,
               GREATEST(0, DATEDIFF(CURDATE(), p.fecha_devolucion)) AS dias_retraso,
               IFNULL(m.monto, 0) AS multa_real
        FROM prestamos p
        JOIN libros l ON p.id_libro = l.id_libro
        LEFT JOIN multas m ON p.id_prestamo = m.id_prestamo
        WHERE p.id_usuario = ? AND p.estado_prestamo = 'Activo'";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_usuario);
$stmt->execute();
$result = $stmt->get_result();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mis Préstamos</title>
    <link rel="stylesheet" href="assets/css/prestamoStyle.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

<h2>Mis Préstamos</h2>

<?php
if (!empty($mensaje)) {
    echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: 'Información',
                    text: '$mensaje',
                    icon: 'info',
                    confirmButtonText: 'OK'
                }).then(() => {
                    window.location = 'mis_prestamos.php';
                });
            });
          </script>";
}
?>

<?php
if ($result->num_rows > 0) {
    echo "<table border='1'>
            <tr>
                <th>ID Préstamo</th>
                <th>Título</th>
                <th>Fecha Préstamo</th>
                <th>Fecha Devolución</th>
                <th>Renovaciones</th>
                <th>Estado</th>
                <th>Días de Retraso</th>
                <th>Multa</th>
                <th>Deposito</th>
                <th>Acción</th>
            </tr>";
    while ($prestamo = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . $prestamo['id_prestamo'] . "</td>
                <td>" . $prestamo['titulo'] . "</td>
                <td>" . $prestamo['fecha_prestamo'] . "</td>
                <td>" . $prestamo['fecha_devolucion'] . "</td>
                <td>" . $prestamo['renovaciones'] . "</td>
                <td>" . $prestamo['estado_prestamo'] . "</td>
                <td>" . $prestamo['dias_retraso'] . "</td>
                <td>" . ($prestamo['multa_real'] > 0 ? "$" . $prestamo['multa_real'] : "Ninguna") . "</td>
                <td>" . $prestamo['deposito'] . "</td>
                <td><a href='renovar_prestamo.php?id_prestamo=" . $prestamo['id_prestamo'] . "'>Renovar</a></td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "<p>No tienes préstamos activos.</p>";
}
?>

<div>
    <a href="dashboard.php" class="btn btn-success w-100">Dashboard</a>
</div>

</body>
</html>