-- ================================================
-- SCRIPT DE BASE DE DATOS - Refugio SalvaVidas
-- Versión reducida para practicar en casa (Login + Listado)
-- ================================================

DROP DATABASE IF EXISTS refugio;
CREATE DATABASE IF NOT EXISTS refugio;
USE refugio;

-- ================================================
-- USUARIOS (para el Login)
-- ================================================
CREATE TABLE usuarios (
    id               INT AUTO_INCREMENT PRIMARY KEY,
    usuario          VARCHAR(50)  NOT NULL UNIQUE,
    password         VARCHAR(255) NOT NULL,
    nombre_completo  VARCHAR(100) NOT NULL
);

-- Password: "password" (hash generado con password_hash)
INSERT INTO usuarios (usuario, password, nombre_completo) VALUES
('pepe',   '$2y$10$0WXeJUcWFgr3FL2kthFwEuUMT.VHJXMJfD7DlW.kryAkhgKbf2nPS', 'Pepe Lluyot'),
('cliente','$2y$10$0WXeJUcWFgr3FL2kthFwEuUMT.VHJXMJfD7DlW.kryAkhgKbf2nPS', 'Juan Cliente');

-- ================================================
-- ANIMALES (para el Listado/Dashboard)
-- ================================================
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
    created_at          TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT chk_adiestramiento CHECK (nivel_adiestramiento BETWEEN 0 AND 100),
    CONSTRAINT chk_puntos_expediente  CHECK (puntos_expediente BETWEEN 0 AND 100)
);

INSERT INTO animales (nombre, especie, raza, edad, peso, imagen, nivel_adiestramiento, puntos_expediente) VALUES
('Luna',   'felino', 'Siamés',  2,  3.80, 'gato1.jpg', 8, 90),
('Thor',   'canino', 'Border Collie', 3, 18.50, 'perro1.jpg', 3, 45),
('Nala',   'canino', 'Golden Retriever', 0,  6.40, 'perro4.jpg', 5, 75);

-- ================================================
-- USUARIO Y PERMISOS
-- ================================================
CREATE USER IF NOT EXISTS 'dwes25'@'localhost' IDENTIFIED BY 'dwes';
GRANT SELECT, INSERT, UPDATE, DELETE ON refugio.* TO 'dwes25'@'localhost';
FLUSH PRIVILEGES;