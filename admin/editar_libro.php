<?php
include 'conexion.php';
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['id_usuario'])) {
    header('Location: login.php');
    exit();
}

$id_libro = null;
$libro = null;

// Procesar la búsqueda del libro si el formulario fue enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['buscar_libro'])) {
    // Validar y obtener el id_libro desde el formulario
    if (isset($_POST['id_libro']) && filter_var($_POST['id_libro'], FILTER_VALIDATE_INT)) {
        $id_libro = $_POST['id_libro'];

        // Consultar la información del libro
        $sql = "SELECT * FROM libros WHERE id_libro = '$id_libro'";
        $result = $conn->query($sql);

        // Verificar si el libro existe
        if ($result->num_rows > 0) {
            $libro = $result->fetch_assoc();
        } else {
            echo "<p class='text-danger'>Error: No se encontró el libro con el ID proporcionado.</p>";
        }
    } else {
        echo "<p class='text-danger'>Error: El ID del libro no es válido.</p>";
    }
}

    // Procesar la actualización del libro si el formulario fue enviado
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['actualizar_libro'])) {
        $id_libro = $_POST['id_libro'];
        $titulo = $conn->real_escape_string($_POST['titulo']);
        $autor = $conn->real_escape_string($_POST['autor']);
        $editorial = $conn->real_escape_string($_POST['editorial']);
        $anio_publicacion = $conn->real_escape_string($_POST['anio_publicacion']);
        $edicion = $conn->real_escape_string($_POST['edicion']);
        $estado = $conn->real_escape_string($_POST['estado']);
        $disponibilidad = $conn->real_escape_string($_POST['disponibilidad']);
        $fecha_disponible = $conn->real_escape_string($_POST['fecha_disponible']);

    // Query para actualizar la información del libro
            $sql_update = "UPDATE libros SET 
               titulo = '$titulo',
               autor = '$autor',
               editorial = '$editorial',
               año_publicacion = '$anio_publicacion',
               edicion = '$edicion',
               estado = '$estado',
               disponibilidad = '$disponibilidad',
               fecha_disponible= '$fecha_disponible'
               WHERE id_libro = '$id_libro'";


    if ($conn->query($sql_update) === TRUE) {
        echo "<p class='text-success'>Libro actualizado exitosamente.</p>";
    } else {
        echo "<p class='text-danger'>Error al actualizar el libro: " . $conn->error . "</p>";
    }
}
?>

<!-- Formulario para buscar libro por ID -->
<h3>Buscar Libro por ID</h3>
<form method="POST" action="dashboard.php?modulo=editar_libro">
    <div class="mb-3">
        <label for="id_libro" class="form-label">ID del Libro</label>
        <input type="number" name="id_libro" class="form-control" required>
    </div>
    <button type="submit" name="buscar_libro" class="btn btn-primary">Buscar Libro</button>
</form>

<?php if ($libro): ?>
<!-- Formulario para editar libro -->
<h3>Editar Libro</h3>
<form method="POST" action="">
    <input type="hidden" name="id_libro" value="<?php echo $id_libro; ?>">
    <div class="mb-3">
        <label for="titulo" class="form-label">Título</label>
        <input type="text" name="titulo" class="form-control" value="<?php echo htmlspecialchars($libro['titulo']); ?>" required>
    </div>
    <div class="mb-3">
        <label for="autor" class="form-label">Autor</label>
        <input type="text" name="autor" class="form-control" value="<?php echo htmlspecialchars($libro['autor']); ?>" required>
    </div>
    <div class="mb-3">
        <label for="editorial" class="form-label">Editorial</label>
        <input type="text" name="editorial" class="form-control" value="<?php echo htmlspecialchars($libro['editorial']); ?>" required>
    </div>
    <div class="mb-3">
        <label for="anio_publicacion" class="form-label">Año de Publicación</label>
        <input type="number" name="anio_publicacion" class="form-control" value="<?php echo htmlspecialchars($libro['año_publicacion']); ?>" required>
    </div>
    <div class="mb-3">
        <label for="edicion" class="form-label">Edición</label>
        <input type="text" name="edicion" class="form-control" value="<?php echo htmlspecialchars($libro['edicion']); ?>" required>
    </div>
    <div class="mb-3">
        <label for="disponibilidad" class="form-label">Disponibles</label>
        <input type="number" name="disponibilidad" class="form-control" value="<?php echo htmlspecialchars($libro['disponibilidad']); ?>" required>
    </div>
    <div class="mb-3">
        <label for="estado" class="form-label">Estado</label>
        <select name="estado" class="form-control" required>
            <option value="Disponible" <?php if ($libro['estado'] == 'Disponible') echo 'selected'; ?>>Disponible</option>
            <option value="Prestado" <?php if ($libro['estado'] == 'Prestado') echo 'selected'; ?>>Prestado</option>
            <option value="No Disponible" <?php if ($libro['estado'] == 'No Disponible') echo 'selected'; ?>>No Disponible</option>
        </select>
    </div>
    <div class="mb-3">
        <label for="fecha_disponible" class="form-label">De Regreso Al Inventario</label>
        <input type="date" name="fecha_disponible" class="form-control" value="<?php echo htmlspecialchars($libro['fecha_disponible']); ?>" required>
    </div>
    <button type="submit" name="actualizar_libro" class="btn btn-primary">Actualizar Libro</button>
</form>
<?php endif; ?>