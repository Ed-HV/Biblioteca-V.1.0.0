<?php
include ('conexion.php'); 
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Sistema de Préstamo de Libros</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

    <style>
        /* Estilo adicional para hacer que el sidebar ocupe todo el alto de la pantalla */
        body, html {
            height: 100%;
            margin: 0;
        }
        #wrapper {
            display: flex;
            min-height: 100vh;
            flex-direction: row;
        }
        #sidebar-wrapper {
            width: 250px;
            background-color: #343a40; /* Color oscuro para el fondo */
            color: white; /* Texto blanco en el sidebar */
            height: 100%;
            padding-top: 20px;
            position: fixed;
            transition: width 0.3s ease; /* Agregado para animar el sidebar en caso de que cambie de tamaño */
        }
        #sidebar-wrapper .list-group-item {
            color: white;
            background-color: #343a40; /* Fondo oscuro para los elementos del menú */
            border: none; /* Eliminar borde */
            padding: 15px 20px; /* Aumenta el padding para hacer más grandes los rectángulos */
            font-size: 1.2rem; /* Aumentar el tamaño de la fuente */
            height: 53px; /* Aumentar la altura de cada elemento */
            display: flex;
            align-items: center;
        }
        #sidebar-wrapper .list-group-item:hover {
            background-color: #495057; /* Fondo más claro cuando se pasa el cursor */
        }
        #sidebar-wrapper .sidebar-heading {
            font-size: 1.5rem;
            font-weight: bold;
            text-align: center;
            padding: 20px;
        }
        #page-content-wrapper {
            margin-left: 250px;
            padding: 20px;
            width: 100%;
           
        }
        .navbar {
            background-color: #f8f9fa;
        }
        .container-fluid {
            max-width: 1200px;
           
        }
        h3 {
            margin-top: 30px;
            font-size: 2rem;
        }
    </style>
</head>

<body>

    <div class="d-flex" id="wrapper">
        <!-- Sidebar -->
        <div class="bg-dark border-end" id="sidebar-wrapper">
            <div class="sidebar-heading text-white text-center p-2">Universidad Tecnologica NovaHorizonte</div>
            <div class="list-group list-group-flush">
                <a href="dashboard.php?modulo=agregar_libro" class="list-group-item  list-group-item-action">Agregar Libro</a>
                <a href="dashboard.php?modulo=editar_libro&id_libro=123" class="list-group-item list-group-item-action">Editar Libro</a>
                <a href="dashboard.php?modulo=eliminar_libro" class="list-group-item list-group-item-action">Eliminar Libro</a>
                <a href="dashboard.php?modulo=registrar_prestamo" class="list-group-item list-group-item-action">Registrar Préstamo</a>
                <a href="dashboard.php?modulo=registrar_devolucion" class="list-group-item list-group-item-action">Registrar Devolución</a>
                <a href="dashboard.php?modulo=gestionar_multas" class="list-group-item list-group-item-action">Gestionar Multas</a>
                <a href="dashboard.php?modulo=reportes" class="list-group-item list-group-item-action">Reportes</a>
                <a href="dashboard.php?modulo=reporte_fechas" class="list-group-item list-group-item-action">Proximas Entregas</a>
                <a href="dashboard.php?modulo=libros_retardo" class="list-group-item list-group-item-action">Retardos</a>
                <a href="dashboard.php?modulo=reporte_renovaciones" class="list-group-item list-group-item-action">Reportes Renovaciones</a>
                <a href="dashboard.php?modulo=reporte_adeudos" class="list-group-item list-group-item-action">Adeudos</a>
                <a href="dashboard.php?modulo=usuarios" class="list-group-item list-group-item-action">Usuarios</a>
            </div>
        </div>

        <!-- Page Content -->
        <div id="page-content-wrapper">
            <nav class="navbar navbar-expand-lg navbar-light bg-dark text-white border-bottom">
                <div class="container-fluid">
                    <h4 class="ms-3 text-center w-100">Universidad Tecnológica NovaHorizonte - Administrador</h4>
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
                        echo "<h3>Bienvenido Al Dashboard Del Administrador </h3><p>Biblioteca NovaHorizonte.</p>";
                    }
                ?>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <script src="assets/js/scripts.js"></script> 
</body>

</html>
