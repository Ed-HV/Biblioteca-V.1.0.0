-- Creación de la base de datos
CREATE DATABASE IF NOT EXISTS sistema_prestamo_libros;
USE sistema_prestamo_libros;

-- Tabla de Usuarios (Alumnos y Profesores)
CREATE TABLE usuarios (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    tipo_usuario ENUM('Alumno', 'Profesor') NOT NULL,
    matricula_credencial VARCHAR(50) NOT NULL UNIQUE,
    nivel_educativo ENUM('Preparatoria', 'Profesional', 'Maestría') DEFAULT NULL,
    email VARCHAR(100),
    telefono VARCHAR(20)
);

CREATE TABLE notificaciones (
  id_notificacion int(11) NOT NULL,
  id_usuario int(11) NOT NULL,
  mensaje text NOT NULL,
  leida tinyint(1) DEFAULT 0,
  fecha_creacion timestamp NOT NULL DEFAULT current_timestamp()
);



-- Tabla de Libros
CREATE TABLE libros (
    id_libro INT AUTO_INCREMENT PRIMARY KEY,
    isbn VARCHAR(20) NOT NULL UNIQUE,
    codigo_barras VARCHAR(50) NOT NULL UNIQUE,
    titulo VARCHAR(200) NOT NULL,
    autor VARCHAR(100),
    editorial VARCHAR(100),
    año_publicacion YEAR,
    edicion VARCHAR(50),
    estado ENUM('Disponible', 'Prestado', 'Reservado') DEFAULT 'Disponible'
);

-- Tabla de Préstamos
CREATE TABLE prestamos (
    id_prestamo INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT,
    id_libro INT,
    fecha_prestamo DATE NOT NULL,
    fecha_devolucion DATE NOT NULL,
    renovaciones INT DEFAULT 0,
    estado_prestamo ENUM('Activo', 'Devuelto', 'Retrasado') DEFAULT 'Activo',
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario),
    FOREIGN KEY (id_libro) REFERENCES libros(id_libro)
);

-- Tabla de Multas
CREATE TABLE multas (
    id_multa INT AUTO_INCREMENT PRIMARY KEY,
    id_prestamo INT,
    monto DECIMAL(10,2) DEFAULT 0.00,
    dias_retraso INT DEFAULT 0,
    estado_multa ENUM('Pendiente', 'Pagada') DEFAULT 'Pendiente',
    FOREIGN KEY (id_prestamo) REFERENCES prestamos(id_prestamo)
);

-- Tabla de Historial de Actividades
CREATE TABLE historial_actividades (
    id_actividad INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT,
    tipo_actividad VARCHAR(50),
    fecha_actividad DATETIME DEFAULT CURRENT_TIMESTAMP,
    descripcion TEXT,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario)
);

-- ========================================
-- PROCEDIMIENTOS ALMACENADOS
-- ========================================

-- 1. Procedimiento para registrar un préstamo
DELIMITER $$
CREATE PROCEDURE registrar_prestamo (
    IN p_id_usuario INT,
    IN p_id_libro INT
)
BEGIN
    DECLARE prestamos_activos INT;

    -- Verificar el número de préstamos activos del usuario
    SELECT COUNT(*) INTO prestamos_activos 
    FROM prestamos 
    WHERE id_usuario = p_id_usuario AND estado_prestamo = 'Activo';
    
    IF prestamos_activos >= 3 THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'El usuario ya tiene 3 préstamos activos.';
    ELSE
        -- Insertar el préstamo
        INSERT INTO prestamos (id_usuario, id_libro, fecha_prestamo, fecha_devolucion)
        VALUES (p_id_usuario, p_id_libro, CURDATE(), DATE_ADD(CURDATE(), INTERVAL 4 DAY));
        
        -- Actualizar el estado del libro a 'Prestado'
        UPDATE libros SET estado = 'Prestado' WHERE id_libro = p_id_libro;
        
        -- Registrar actividad en el historial
        INSERT INTO historial_actividades (id_usuario, tipo_actividad, descripcion)
        VALUES (p_id_usuario, 'Préstamo', CONCAT('Préstamo del libro ID ', p_id_libro));
    END IF;
END$$
DELIMITER ;

-- 2. Procedimiento para registrar una devolución
DELIMITER $$
CREATE PROCEDURE registrar_devolucion (
    IN p_id_prestamo INT
)
BEGIN
    DECLARE p_id_libro INT;
    DECLARE fecha_devolucion DATE;
    DECLARE dias_retraso INT;

    -- Obtener el libro asociado al préstamo y la fecha de devolución
    SELECT id_libro, fecha_devolucion INTO p_id_libro, fecha_devolucion
    FROM prestamos WHERE id_prestamo = p_id_prestamo;

    -- Calcular retraso
    SET dias_retraso = DATEDIFF(CURDATE(), fecha_devolucion);
    
    -- Si hay retraso, registrar multa
    IF dias_retraso > 0 THEN
        INSERT INTO multas (id_prestamo, monto, dias_retraso)
        VALUES (p_id_prestamo, dias_retraso * 10, dias_retraso);
    END IF;
    
    -- Actualizar el estado del préstamo a 'Devuelto'
    UPDATE prestamos SET estado_prestamo = 'Devuelto' WHERE id_prestamo = p_id_prestamo;
    
    -- Cambiar el estado del libro a 'Disponible'
    UPDATE libros SET estado = 'Disponible' WHERE id_libro = p_id_libro;

    -- Registrar actividad en el historial
    INSERT INTO historial_actividades (id_usuario, tipo_actividad, descripcion)
    SELECT id_usuario, 'Devolución', CONCAT('Devolución del libro ID ', p_id_libro)
    FROM prestamos WHERE id_prestamo = p_id_prestamo;
END$$
DELIMITER ;

-- 3. Procedimiento para pagar multas
DELIMITER $$
CREATE PROCEDURE pagar_multa (
    IN p_id_multa INT
)
BEGIN
    -- Marcar la multa como pagada
    UPDATE multas SET estado_multa = 'Pagada' WHERE id_multa = p_id_multa;
    
    -- Registrar actividad en el historial
    INSERT INTO historial_actividades (id_usuario, tipo_actividad, descripcion)
    SELECT p.id_usuario, 'Pago de Multa', CONCAT('Pago de multa ID ', p_id_multa)
    FROM prestamos p
    JOIN multas m ON p.id_prestamo = m.id_prestamo
    WHERE m.id_multa = p_id_multa;
END$$
DELIMITER ;

-- ========================================
-- EJEMPLOS DE USO DE PROCEDIMIENTOS
-- ========================================

-- Registrar un nuevo préstamo
-- CALL registrar_prestamo(1, 2);

-- Registrar la devolución de un libro
-- CALL registrar_devolucion(1);

-- Pagar una multa
-- CALL pagar_multa(1);
