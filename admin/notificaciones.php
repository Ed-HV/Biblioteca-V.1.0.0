<?php
include 'conexion.php';

// Notificaciones de libros reservados
$sql_reservados = "SELECT titulo, estado FROM libros WHERE estado = 'Reservado'";
$result_reservados = $conn->query($sql_reservados);

// Notificaciones de devoluciones pendientes
$sql_pendientes = "SELECT u.nombre, l.titulo, p.fecha_devolucion 
                   FROM prestamos p 
                   JOIN usuarios u ON p.id_usuario = u.id_usuario 
                   JOIN libros l ON p.id_libro = l.id_libro 
                   WHERE p.estado_prestamo = 'Activo' AND p.fecha_devolucion < CURDATE()";
$result_pendientes = $conn->query($sql_pendientes);

// Notificaciones de multas pendientes
$sql_multas = "SELECT u.nombre, m.monto, m.dias_retraso 
               FROM multas m 
               JOIN prestamos p ON m.id_prestamo = p.id_prestamo 
               JOIN usuarios u ON p.id_usuario = u.id_usuario 
               WHERE m.estado_multa = 'Pendiente'";
$result_multas = $conn->query($sql_multas);
?>

<h2>Notificaciones del Sistema</h2>

<!-- Libros Reservados -->
<h3>📚 Libros Reservados</h3>
<?php
if ($result_reservados->num_rows > 0) {
    while ($libro = $result_reservados->fetch_assoc()) {
        echo "El libro <strong>" . $libro['titulo'] . "</strong> está reservado.<br>";
    }
} else {
    echo "No hay libros reservados.<br>";
}
?>

<!-- Devoluciones Pendientes -->
<h3>⏳ Devoluciones Pendientes</h3>
<?php
if ($result_pendientes->num_rows > 0) {
    while ($pendiente = $result_pendientes->fetch_assoc()) {
        echo "El usuario <strong>" . $pendiente['nombre'] . "</strong> tiene pendiente la devolución del libro <strong>" . $pendiente['titulo'] . "</strong> (Fecha límite: " . $pendiente['fecha_devolucion'] . ").<br>";
    }
} else {
    echo "No hay devoluciones pendientes.<br>";
}
?>

<!-- Multas Pendientes -->
<h3>💸 Multas Pendientes</h3>
<?php
if ($result_multas->num_rows > 0) {
    while ($multa = $result_multas->fetch_assoc()) {
        echo "El usuario <strong>" . $multa['nombre'] . "</strong> tiene una multa pendiente de <strong>$" . $multa['monto'] . "</strong> por <strong>" . $multa['dias_retraso'] . " días</strong> de retraso.<br>";
    }
} else {
    echo "No hay multas pendientes.<br>";
}
?>

