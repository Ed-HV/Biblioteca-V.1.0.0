#  Sistema de Préstamo de Libros

Este proyecto es un sistema de gestión de préstamos de libros para la **Universidad X**. El sistema permite a los **administradores** gestionar libros, préstamos y multas, mientras que los **usuarios** (alumnos y profesores) pueden buscar libros, realizar préstamos y consultar su historial.

##  Características

### Para Administradores:
- **Gestión de Libros:** Agregar, editar y eliminar libros.
- **Gestión de Préstamos:** Registrar préstamos y devoluciones.
- **Gestión de Multas:** Calcular y registrar multas por retraso en devoluciones.
- **Generación de Reportes:** Ver reportes de libros prestados, devoluciones, retrasos y adeudos.
- **Notificaciones:** Avisar la disponibilidad de libros y envíos de recordatorios de devolución.

### Para Usuarios:
- **Búsqueda de Libros:** Consultar libros disponibles por título, autor o ISBN.
- **Préstamos de Libros:** Solicitar préstamos (máximo 3 libros simultáneamente).
- **Renovación de Préstamos:** Renovar préstamos hasta 3 veces.
- **Historial de Préstamos:** Consultar historial y estado de préstamos.
- **Notificaciones:** Recibir alertas sobre devoluciones pendientes y multas.

---

## 🛠️ Tecnologías Utilizadas

- **PHP** (Backend)
- **MySQL** (Base de Datos)
- **phpMyAdmin** (Gestión de la Base de Datos)
- **HTML/CSS** (Frontend)
- **Bootstrap** (Opcional, para el diseño responsivo)
- **JavaScript** (Opcional, para validaciones en el cliente)

---

## 📦 Instalación

### 1. Clonar el Repositorio
Si estás usando Git:

git clone https://github.com/Ed-HV/Biblioteca-V.1.0.0.git
cd Biblioteca-V.1.0.0.

2. Configuración del Entorno
Asegúrate de tener XAMPP instalado para correr el servidor local.
Coloca el proyecto en la carpeta htdocs de XAMPP.

3. Configurar la Base de Datos

Abre phpMyAdmin desde tu servidor local (http://localhost/phpmyadmin).
Crea una nueva base de datos llamada sistema_prestamo_libros.
Importa el archivo SQL que viene incluido.

4. Configuración de Conexión a la Base de Datos

Edita el archivo conexion.php con tus credenciales de base de datos:

<?php
$host = 'localhost';
$user = 'root';         // Cambia si tienes un usuario diferente
$password = '';   // Añade tu contraseña si la tienes
$port= ;      
$database = 'sistema_prestamo_libros';

$conn = new mysqli($host, $user, $password, $database,$port);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>

5. Ejecutar el Proyecto

Abre tu navegador y visita:

http://localhost/sistema-prestamo-libros/usuario/login.php  # Para usuarios
http://localhost/sistema-prestamo-libros/admin/agregar_libro.php  # Para administradores
🗄️ Estructura del Proyecto
bash
Copiar
Editar
/admin
  ├── dashboard.php
  ├── agregar_libro.php
  ├── editar_libro.php
  ├── eliminar_libro.php
  ├── registrar_prestamo.php
  ├── registrar_devolucion.php
  ├── gestionar_multas.php
  ├── reportes.php
  └── conexion.php

/usuario
  ├── dashboard.php
  ├── buscar_libros.php
  ├── mis_prestamos.php
  ├── renovar_prestamo.php
  ├── historial.php
  ├── notificaciones.php
  ├── login.php
  └── conexion.php

## Funcionalidades Clave
- Límite de Préstamos: Un usuario puede tener un máximo de 3 libros en préstamo simultáneamente.
- Renovaciones: Los préstamos pueden renovarse hasta 3 veces; luego, se debe esperar 2 semanas para volver a solicitar el mismo libro.
- Multas: $10.00 por cada día de retraso en la devolución.
- Notificaciones: Se notificará cuando todos los ejemplares de un libro estén prestados o cuando la devolución esté pendiente.

    Apache License Version 2.0, January 2004  http://www.apache.org/licenses/
                           
                