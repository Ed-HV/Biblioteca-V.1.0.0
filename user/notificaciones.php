<?php
// Incluir la conexión a la base de datos
include 'conexion.php';
session_start();

// Verificar si el usuario está logueado
if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php");
    exit();
}

// Obtener el ID del usuario de la sesión
$id_usuario = $_SESSION['id_usuario'];

// Consultar los libros que están "No disponibles" y su fecha de disponibilidad
$sql = "
    SELECT l.id_libro, l.titulo, l.fecha_disponible
    FROM libros l
    WHERE l.estado = 'No disponible' AND l.fecha_disponible > CURDATE()
";

$result = $conn->query($sql);

// Si hay libros no disponibles
if ($result->num_rows > 0) {
    // Preparar el mensaje para el usuario
    $mensaje = "Estos libros estarán disponibles próximamente:\n\n";

    while ($row = $result->fetch_assoc()) {
        $mensaje .= "Libro: " . $row['titulo'] . "\n";
        $mensaje .= "Disponible el: " . $row['fecha_disponible'] . "\n\n";
    }

    // Insertar la notificación en la tabla de notificaciones
    $sql_insert = "INSERT INTO notificaciones (id_usuario, mensaje) VALUES ('$id_usuario', '$mensaje')";
    if ($conn->query($sql_insert) === TRUE) {
        $notification_status = "Notificación enviada con éxito.";
    } else {
        $notification_status = "Error al enviar la notificación: " . $conn->error;
    }
} else {
    $notification_status = "No hay libros no disponibles.";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notificaciones</title>
    <!-- Bootstrap CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="assets/css/notificacionStyle.css"
</head>
<body> 
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <h2 class="mb-4">Notificaciones</h2>
                
                <?php if(isset($notification_status)): ?>
                    <div class="alert alert-info mb-4"><?php echo $notification_status; ?></div>
                <?php endif; ?>
                
                <?php
                // Consultar las notificaciones no leídas del usuario
                $sql_notificaciones = "SELECT mensaje, fecha_envio FROM notificaciones WHERE id_usuario = '$id_usuario' AND leido = 0 ORDER BY fecha_envio DESC";
                $result_notificaciones = $conn->query($sql_notificaciones);

                if ($result_notificaciones->num_rows > 0) {
                    while ($row = $result_notificaciones->fetch_assoc()) {
                        echo '<div class="card notification-card">';
                        echo '<div class="card-body">';
                        echo '<h5 class="card-title">Nueva notificación</h5>';
                        echo '<p class="card-text notification-message">' . nl2br(htmlspecialchars($row['mensaje'])) . '</p>';
                        echo '<p class="card-text"><small class="text-muted">Fecha: ' . $row['fecha_envio'] . '</small></p>';
                        echo '</div>';
                        echo '</div>';

                        // Marcar la notificación como leída después de mostrarla
                        $sql_update = "UPDATE notificaciones SET leido = 1 WHERE id_usuario = '$id_usuario' AND mensaje = '" . $conn->real_escape_string($row['mensaje']) . "'";
                        $conn->query($sql_update);
                    }
                } else {
                    echo '<div class="alert alert-warning">No tienes notificaciones nuevas.</div>';
                }
                ?>
                
                <!-- Botón para ver notificaciones anteriores -->
                <div class="mt-4">
                    <a href="dashboard.php" class="btn btn-outline-secondary me-2">Dashboard </a>
                </div>
                
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle with Popper CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>