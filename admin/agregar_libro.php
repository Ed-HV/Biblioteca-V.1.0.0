<?php
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $isbn = $conn->real_escape_string($_POST['isbn']);
    $codigo_barras = $conn->real_escape_string($_POST['codigo_barras']);
    $titulo = $conn->real_escape_string($_POST['titulo']);
    $autor = $conn->real_escape_string($_POST['autor']);
    $editorial = $conn->real_escape_string($_POST['editorial']);
    $anio_publicacion = $conn->real_escape_string($_POST['anio_publicacion']);
    $edicion = $conn->real_escape_string($_POST['edicion']);
    $disponibilidad = $conn->real_escape_string($_POST['disponibilidad']);

    // Verificar si el ISBN ya existe
    $check_sql = "SELECT * FROM libros WHERE isbn = '$isbn'";
    $result = $conn->query($check_sql);

    if ($result->num_rows > 0) {
        echo "<script>         
               alert('⚠️ Error: El ISBN ya está registrado en la base de datos.');
                window.history.back();
              </script>";
    } else {
        // Insertar el nuevo libro si el ISBN no existe
        $sql = "INSERT INTO libros (isbn, codigo_barras, titulo, autor, editorial, año_publicacion, edicion, disponibilidad) 
                VALUES ('$isbn', '$codigo_barras', '$titulo', '$autor', '$editorial', '$anio_publicacion', '$edicion', '$disponibilidad')";

        if ($conn->query($sql) === TRUE) {
            echo "<script>
                    alert('✅ Libro agregado exitosamente.');
                    window.location.href = 'dashboard.php?modulo=agregar_libro';
                  </script>";
        } else {
            echo "<script>
                    alert('⚠️ Error al agregar el libro: " . addslashes($conn->error) . "');
                  </script>";
        }
    }
}
?>

<!-- Formulario para agregar libro -->
<h3>Agregar Nuevo Libro</h3>
<form method="POST" action="dashboard.php?modulo=agregar_libro">
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
    <div class="mb-3">
        <label for="disponibilidad" class="form-label">Cantidad de Libros</label>
        <input type="text" name="disponibilidad" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-primary">Agregar Libro</button>
</form>
