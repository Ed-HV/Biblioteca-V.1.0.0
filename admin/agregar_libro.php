<?php
include 'conexion.php';
session_start();

if (!isset($_SESSION['id_usuario'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $isbn = $conn->real_escape_string($_POST['isbn']);
    $codigo_barras = $conn->real_escape_string($_POST['codigo_barras']);
    $titulo = $conn->real_escape_string($_POST['titulo']);
    $autor = $conn->real_escape_string($_POST['autor']);
    $editorial = $conn->real_escape_string($_POST['editorial']);
    $anio_publicacion = $conn->real_escape_string($_POST['anio_publicacion']);
    $edicion = $conn->real_escape_string($_POST['edicion']);

    // Consulta SQL corregida
    $sql = "INSERT INTO libros (isbn, codigo_barras, titulo, autor, editorial, año_publicacion, edicion) 
            VALUES ('$isbn', '$codigo_barras', '$titulo', '$autor', '$editorial', '$anio_publicacion', '$edicion')";

    if ($conn->query($sql) === TRUE) {
        echo "<p class='text-success'>Libro agregado exitosamente.</p>";
    } else {
        echo "<p class='text-danger'>Error al agregar el libro: " . $conn->error . "</p>";
    }
}
?>

<!-- Formulario para agregar libro -->
<h3>Agregar Nuevo Libro</h3>
<form method="POST" action="agregar_libro.php">
    <div class="mb-3">
        <label for="isbn" class="form-label">ISBN</label>
        <input type="text" name="isbn" class="form-control" required>
    </div>
    <div class="mb-3">
        <label for="codigo_barras" class="form-label">Código de Barras</label>
        <input type="text" name="codigo_barras" class="form-control" required>
    </div>
    <div class="mb-3">
        <label for="titulo" class="form-label">Título</label>
        <input type="text" name="titulo" class="form-control" required>
    </div>
    <div class="mb-3">
        <label for="autor" class="form-label">Autor</label>
        <input type="text" name="autor" class="form-control" required>
    </div>
    <div class="mb-3">
        <label for="editorial" class="form-label">Editorial</label>
        <input type="text" name="editorial" class="form-control" required>
    </div>
    <div class="mb-3">
        <label for="anio_publicacion" class="form-label">Año de Publicación</label>
        <input type="number" name="anio_publicacion" class="form-control" required>
    </div>
    <div class="mb-3">
        <label for="edicion" class="form-label">Edición</label>
        <input type="text" name="edicion" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-primary">Agregar Libro</button>
   
</form>
