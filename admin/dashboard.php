<?php
 include ('conexion.php'); 
 ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Sistema de Préstamo de Libros</title>
    
  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/dashboardStyle.css">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
   
   <link rel="" href="assets/css/dashboardStyle.css">
</head>
<body>
    <div class="d-flex" id="wrapper">

        
        <div class="bg-dark border-end" id="sidebar-wrapper">
            <div class="sidebar-heading text-white p-3">📚 Biblioteca Admin</div>
            <div class="list-group list-group-flush">
                <a href="dashboard.php?modulo=agregar_libro" class="list-group-item list-group-item-action bg-dark text-white">Agregar Libro</a>
                <a href="dashboard.php?modulo=editar_libro&id_libro=123" class="btn btn-warning">Editar Libro</a>
                <a href="dashboard.php?modulo=eliminar_libro" class="list-group-item list-group-item-action bg-dark text-white">Eliminar Libro</a>
                <a href="dashboard.php?modulo=registrar_prestamo" class="list-group-item list-group-item-action bg-dark text-white">Registrar Préstamo</a>
                <a href="dashboard.php?modulo=registrar_devolucion" class="list-group-item list-group-item-action bg-dark text-white">Registrar Devolución</a>
                <a href="dashboard.php?modulo=gestionar_multas" class="list-group-item list-group-item-action bg-dark text-white">Gestionar Multas</a>
                <a href="dashboard.php?modulo=reportes" class="list-group-item list-group-item-action bg-dark text-white">Reportes</a>
                <a href="dashboard.php?modulo=notificaciones" class="list-group-item list-group-item-action bg-dark text-white">Notificaciones</a>
            </div>
        </div>
        

        
        <div id="page-content-wrapper">
            <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
                <div class="container-fluid">
                    
                    <h4 class="ms-3">Universidad Tecnológica NovaHorizonte - Administrador</h4>
                </div>
            </nav>

            <div class="container-fluid mt-4">
                <?php
                    // Cargar el módulo seleccionado
                    if (isset($_GET['modulo'])) {
                        $modulo = $_GET['modulo'];
                        $archivo = $modulo . '.php';

                        if (file_exists($archivo)) {
                            include($archivo);
                        } else {
                            echo "<h4>Módulo no encontrado.</h4>";
                        }
                    } else {
                        echo "<h3>Bienvenido al Dashboard de la Biblioteca 📚</h3><p>Selecciona una opción en el menú para comenzar.</p>";
                    }
                ?>
            </div>
        </div>
      </div>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
   <script src="assets/js/scripts.js"></script> 
    
</body>
</html>
