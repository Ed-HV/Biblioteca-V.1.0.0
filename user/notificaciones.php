<?php
include 'conexion.php';
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['id_usuario'])) {
    header('Location: login.php');
    exit();
}

$id_usuario = $_SESSION['id_usuario'];

// Marcar notificación como leída si se recibe el parámetro
if (isset($_GET['marcar_leida'])) {
    $id_notificacion = $_GET['marcar_leida'];
    $sql_marcar_leida = "UPDATE notificaciones SET leida = 1 WHERE id_notificacion = '$id_notificacion' AND id_usuario = '$id_usuario'";
    $conn->query($sql_marcar_leida);
}

// Obtener las notificaciones del usuario
$sql = "SELECT * FROM notificaciones WHERE id_usuario = '$id_usuario' ORDER BY fecha_creacion DESC";
$result = $conn->query($sql);
?>

<h3>📢 Notificaciones</h3>

<?php if ($result->num_rows > 0): ?>
    <ul class="list-group">
        <?php while ($notificacion = $result->fetch_assoc()): ?>
            <li class="list-group-item <?php echo $notificacion['leida'] ? 'list-group-item-light' : 'list-group-item-warning'; ?>">
                <strong><?php echo htmlspecialchars($notificacion['mensaje']); ?></strong><br>
                <small><?php echo date('d M Y, H:i', strtotime($notificacion['fecha_creacion'])); ?></small>
                
                <?php if (!$notificacion['leida']): ?>
                    <div class="mt-2">
                        <a href="notificaciones.php?marcar_leida=<?php echo $notificacion['id_notificacion']; ?>" class="btn btn-sm btn-success">Marcar como Leída</a>
                    </div>
                <?php endif; ?>
            </li>
        <?php endwhile; ?>
    </ul>
<?php else: ?>
    <p>No tienes notificaciones en este momento.</p>
<?php endif; ?>
