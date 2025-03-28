<?php
include 'conexion.php';

$id_libro = null;
$libro = null;
$mensaje = "";

// Procesar la búsqueda del libro
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['buscar_libro'])) {
    if (isset($_POST['id_libro']) && filter_var($_POST['id_libro'], FILTER_VALIDATE_INT)) {
        $id_libro = $_POST['id_libro'];
        $sql = "SELECT * FROM libros WHERE id_libro = '$id_libro'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $libro = $result->fetch_assoc();
        } else {
            $mensaje = "<div class='alert alert-danger text-center'>Error: No se encontró el libro con el ID proporcionado.</div>";
        }
    } else {
        $mensaje = "<div class='alert alert-danger text-center'>Error: El ID del libro no es válido.</div>";
    }
}

// Procesar la actualización del libro
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
        $mensaje = "<div class='alert alert-success text-center'>Libro actualizado exitosamente.</div>";
    } else {
        $mensaje = "<div class='alert alert-danger text-center'>Error al actualizar el libro: " . $conn->error . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Libro</title>
    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5 ">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h3 class="text-center mb-4">Buscar Libro</h3>

            <!-- Mostrar mensaje de error o éxito -->
            <?php if (!empty($mensaje)) echo $mensaje; ?>

            <!-- Formulario de búsqueda -->
            <form method="POST" action="">
                <div class="mb-3">
                    <label for="id_libro" class="form-label">ID del Libro</label>
                    <input type="number" name="id_libro" class="form-control text-center" required>
                </div>
                <button type="submit" name="buscar_libro" class="btn btn-primary w-100">Buscar Libro</button>
            </form>

            <?php if ($libro): ?>
            <hr>
            <h3 class="text-center mb-4">Editar Libro</h3>

            <!-- Formulario para editar libro -->
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
                        <option value="No Disponible" <?php if ($libro['estado'] == 'No Disponible') echo 'selected'; ?>>No Disponible</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="fecha_disponible" class="form-label">Fecha Disponible</label>
                    <input type="date" name="fecha_disponible" class="form-control" value="<?php echo htmlspecialchars($libro['fecha_disponible']); ?>" required>
                </div>

                <button type="submit" name="actualizar_libro" class="btn btn-success w-100">Actualizar Libro</button>
            </form>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
