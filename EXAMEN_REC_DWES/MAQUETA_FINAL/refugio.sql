DROP DATABASE IF EXISTS refugio;
CREATE DATABASE IF NOT EXISTS refugio;

USE refugio;

-- ================================================
-- USUARIOS
-- ================================================
CREATE TABLE usuarios (
    id               INT AUTO_INCREMENT PRIMARY KEY,
    usuario          VARCHAR(50)  NOT NULL UNIQUE,
    password         VARCHAR(255) NOT NULL,
    nombre_completo  VARCHAR(100) NOT NULL
);

INSERT INTO usuarios (usuario, password, nombre_completo) VALUES 
('pepe',         '$2y$10$0WXeJUcWFgr3FL2kthFwEuUMT.VHJXMJfD7DlW.kryAkhgKbf2nPS', 'Pepe Lluyot'),
('cliente',      '$2y$10$0WXeJUcWFgr3FL2kthFwEuUMT.VHJXMJfD7DlW.kryAkhgKbf2nPS', 'Juan Cliente'),
('adiestrador',  '$2y$10$0WXeJUcWFgr3FL2kthFwEuUMT.VHJXMJfD7DlW.kryAkhgKbf2nPS', 'Ana Adiestradora');


-- ================================================
-- ANIMALES
-- ================================================
CREATE TABLE animales (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    nombre      VARCHAR(50)  NOT NULL,
    especie     ENUM('felino', 'canino', 'otro') NOT NULL DEFAULT 'otro',
    raza        VARCHAR(50)  DEFAULT NULL,
    edad        TINYINT UNSIGNED NOT NULL DEFAULT 0,      -- en años
    peso        DECIMAL(5,2) NOT NULL DEFAULT 0.00,       -- en kg
    imagen    VARCHAR(255) DEFAULT NULL,
    energia     TINYINT UNSIGNED NOT NULL DEFAULT 100,    -- 0-100
    higiene     TINYINT UNSIGNED NOT NULL DEFAULT 100,    -- 0-100
    en_refugio  TINYINT(1)   NOT NULL DEFAULT 1,          -- 1 = activo, 0 = adoptado
    fec_creacion  TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT chk_energia CHECK (energia BETWEEN 0 AND 100),
    CONSTRAINT chk_higiene  CHECK (higiene BETWEEN 0 AND 100)
);

INSERT INTO animales (nombre, especie, raza, edad, peso, imagen, energia, higiene, en_refugio) VALUES
('Luna',   'felino', 'Siamés',  2,  3.80, 'gato1.jpg', 25, 90, 1),
('Thor',   'canino', 'Border Collie', 3, 18.50, 'perro1.jpg', 30, 25, 1),
('Nala',   'canino', 'Golden Retriever', 0,  6.40, 'perro4.jpg', 55, 75, 1),
('Lucas',   'canino', 'Galgo',         4,  9.60, 'perro2.jpg', 55, 75, 1),
('Mochi',  'felino', 'Persa',          1,  4.10, 'gato2.jpg', 95, 80, 1),
('Rocky',  'canino', 'Terrier',        5, 12.00, 'perro3.jpg', 70, 60, 1),
('Manolo',  'canino', 'BullDog',        3, 11.00, 'perro5.jpg', 90, 80, 0)
;


-- ================================================
-- ADOPCIONES (histórico)
-- ================================================
CREATE TABLE adopciones (
    id              INT AUTO_INCREMENT PRIMARY KEY,
    animal_id       INT          NOT NULL,
    nombre_animal   VARCHAR(50)  NOT NULL,  
    especie         ENUM('felino', 'canino', 'otro') NOT NULL,
    edad_adopcion   TINYINT UNSIGNED NOT NULL,
    peso_adopcion   DECIMAL(5,2) NOT NULL,
    energia_final   TINYINT UNSIGNED NOT NULL,
    higiene_final   TINYINT UNSIGNED NOT NULL,
    fecha_adopcion  TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    usuario_id      INT DEFAULT NULL,            -- qué cuidador tramitó la adopción

    CONSTRAINT fk_adopcion_animal  FOREIGN KEY (animal_id)  REFERENCES animales(id) ON DELETE RESTRICT,
    CONSTRAINT fk_adopcion_usuario FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE SET NULL
);


-- ================================================
-- USUARIO Y PERMISOS
-- ================================================
CREATE USER IF NOT EXISTS 'dwes25'@'localhost' IDENTIFIED BY 'dwes';

GRANT SELECT, INSERT, UPDATE, DELETE ON refugio.* TO 'dwes25'@'localhost';

FLUSH PRIVILEGES;