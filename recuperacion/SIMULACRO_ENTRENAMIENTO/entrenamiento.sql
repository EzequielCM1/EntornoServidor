-- =======================================================
-- SQL PARA EL SIMULACRO DE EXAMEN (Base de Datos Aislada)
-- Módulo de Entrenamiento - DATOS Y TABLAS DEL EXAMEN
-- =======================================================

-- 1. Crear y usar una base de datos totalmente nueva y separada
DROP DATABASE IF EXISTS simulacro_refugio;
CREATE DATABASE simulacro_refugio CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE simulacro_refugio;

-- 2. Crear tabla de usuarios (necesario para el login)
-- Estructura del examen, adaptada con password_hash para compatibilidad
CREATE TABLE usuarios (
    id               INT AUTO_INCREMENT PRIMARY KEY,
    usuario          VARCHAR(50)  NOT NULL UNIQUE,
    password_hash    VARCHAR(255) NOT NULL, -- Renombrado de 'password' a 'password_hash'
    nombre_completo  VARCHAR(100) NOT NULL
);

-- 3. Crear tabla de animales (estructura del examen)
-- Se ha añadido la columna 'estado' para el funcionamiento del módulo de entrenamiento
CREATE TABLE animales (
    id                  INT AUTO_INCREMENT PRIMARY KEY,
    nombre              VARCHAR(50)  NOT NULL,
    especie             ENUM('felino', 'canino', 'otro') NOT NULL DEFAULT 'otro',
    raza                VARCHAR(50)  DEFAULT NULL,
    edad                TINYINT UNSIGNED NOT NULL DEFAULT 0,
    peso                DECIMAL(5,2) NOT NULL DEFAULT 0.00,
    imagen              VARCHAR(255) DEFAULT NULL,
    nivel_adiestramiento TINYINT UNSIGNED NOT NULL DEFAULT 1,
    puntos_expediente   TINYINT UNSIGNED NOT NULL DEFAULT 50,
    estado              VARCHAR(50) NOT NULL DEFAULT 'Sano', -- Requerido para Entrenamiento
    created_at          TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT chk_adiestramiento CHECK (nivel_adiestramiento BETWEEN 0 AND 100),
    CONSTRAINT chk_puntos_expediente  CHECK (puntos_expediente BETWEEN 0 AND 100)
);

-- 4. Crear tabla de entrenamientos (tabla específica del simulacro)
CREATE TABLE entrenamientos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_animal INT NOT NULL,
    nivel ENUM('Básico', 'Medio', 'Avanzado') NOT NULL,
    fecha_inicio TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_animal) REFERENCES animales(id) ON DELETE CASCADE
);
CREATE TABLE log_actividades (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    animal_id   INT NOT NULL,
    usuario_id  INT NOT NULL,
    accion      VARCHAR(100) NOT NULL,
    fecha       TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_animal_idx FOREIGN KEY (animal_id) REFERENCES animales(id) ON DELETE CASCADE,
    CONSTRAINT fk_usuario_idx FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
-- =======================================================
-- DATOS DE PRUEBA (Traídos del Examen)
-- =======================================================

-- Usuarios del examen
-- Pepe -> password: "password"
INSERT INTO usuarios (usuario, password_hash, nombre_completo) VALUES
('pepe',   '$2y$10$0WXeJUcWFgr3FL2kthFwEuUMT.VHJXMJfD7DlW.kryAkhgKbf2nPS', 'Pepe Lluyot'),
('cliente','$2y$10$0WXeJUcWFgr3FL2kthFwEuUMT.VHJXMJfD7DlW.kryAkhgKbf2nPS', 'Juan Cliente');

-- Animales del examen
INSERT INTO animales (nombre, especie, raza, edad, peso, imagen, nivel_adiestramiento, puntos_expediente, estado) VALUES
('Luna',   'felino', 'Siamés',  2,  3.80, 'gato1.jpg', 8, 90, 'Sano'),
('Thor',   'canino', 'Border Collie', 3, 18.50, 'perro1.jpg', 3, 45, 'Sano'),
('Nala',   'canino', 'Golden Retriever', 0,  6.40, 'perro4.jpg', 5, 75, 'Sano'),
('Rex',    'canino', 'Pastor Alemán', 4, 25.00, 'perro2.jpg', 4, 60, 'Sano'),
('Mia',    'felino', 'Persa', 1, 2.50, 'gato2.jpg', 7, 85, 'Sano'),
('Pipo',   'otro',   'Conejo', 1, 1.20, 'otro1.jpg', 2, 30, 'Sano'),
('Max',    'canino', 'Beagle', 5, 12.00, 'perro3.jpg', 6, 70, 'Sano'),
('Kira',   'felino', 'Común', 3, 4.00, 'gato3.jpg', 5, 50, 'Sano'),
('Rocky',  'canino', 'Bulldog', 2, 22.00, 'perro4.jpg', 1, 10, 'Sano');

-- =======================================================
-- PERMISOS
-- =======================================================
 -- CREATE USER IF NOT EXISTS 'dwes25'@'localhost' IDENTIFIED BY 'dwes';
 -- GRANT ALL PRIVILEGES ON simulacro_refugio.* TO 'dwes25'@'localhost';
 -- FLUSH PRIVILEGES;

-- Listo. Ejecuta todo este script en tu phpMyAdmin o consola MySQL.

