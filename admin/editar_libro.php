
<?php
include 'conexion.php';
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['id_usuario'])) {
    header('Location: login.php');
    exit();
}

// Verificar si se recibió el id_libro en la URL y si es válido
if (!isset($_GET['id_libro']) || !filter_var($_GET['id_libro'], FILTER_VALIDATE_INT)) {
    echo "<p class='text-danger'>Error: No se especificó un libro válido para editar.</p>";
    exit();
}

$id_libro = $_GET['id_libro'];

// Consultar la información del libro
$sql = "SELECT * FROM libros WHERE id_libro = '$id_libro'";
$result = $conn->query($sql);

// Verificar si el libro existe
if ($result->num_rows == 0) {
    echo "<p class='text-danger'>Error: No se encontró el libro que intentas editar.</p>";
    exit();
}

$libro = $result->fetch_assoc();

// Procesar la actualización del libro si el formulario fue enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $titulo = $conn->real_escape_string($_POST['titulo']);
    $autor = $conn->real_escape_string($_POST['autor']);
    $editorial = $conn->real_escape_string($_POST['editorial']);
    $anio_publicacion = $conn->real_escape_string($_POST['anio_publicacion']);
    $edicion = $conn->real_escape_string($_POST['edicion']);
    $estado = $conn->real_escape_string($_POST['estado']);

    $sql_update = "UPDATE libros SET 
                   titulo = '$titulo',
                   autor = '$autor',
                   editorial = '$editorial',
                   año_publicacion = '$anio_publicacion',
                   edicion = '$edicion',
                   estado = '$estado'
                   WHERE id_libro = '$id_libro'";

    if ($conn->query($sql_update) === TRUE) {
        echo "<p class='text-success'>Libro actualizado exitosamente.</p>";
    } else {
        echo "<p class='text-danger'>Error al actualizar el libro: " . $conn->error . "</p>";
    }
}
?>

<!-- Formulario para editar libro -->
<h3>Editar Libro</h3>
<a href="dashboard.php?modulo=editar_libro&id_libro=123" class="btn btn-warning">Editar Libro</a>
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
        <label for="estado" class="form-label">Estado</label>
        <select name="estado" class="form-control" required>
            <option value="Disponible" <?php if ($libro['estado'] == 'Disponible') echo 'selected'; ?>>Disponible</option>
            <option value="Prestado" <?php if ($libro['estado'] == 'Prestado') echo 'selected'; ?>>Prestado</option>
            <option value="No Disponible" <?php if ($libro['estado'] == 'No Disponible') echo 'selected'; ?>>No Disponible</option>
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Actualizar Libro</button>
</form>
