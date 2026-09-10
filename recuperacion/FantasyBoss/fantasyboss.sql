-- ============================================================
--  FantasyBoss — Base de datos
--  Sistema de Fantasy Fútbol
-- ============================================================

CREATE DATABASE IF NOT EXISTS fantasyboss
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE fantasyboss;

-- ------------------------------------------------------------
-- Tabla: managers  (equivalente a: jugadores / socios)
-- Login: cod_manager + pin (bcrypt)
-- Formato credencial: MAN-001-1234
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS managers (
    cod_manager     VARCHAR(10)     NOT NULL,
    nombre          VARCHAR(100)    NOT NULL,
    apellidos       VARCHAR(100)    NOT NULL,
    pin             VARCHAR(255)    NOT NULL,
    liga            ENUM('Bronce','Plata','Oro','Diamante') NOT NULL DEFAULT 'Bronce',
    puntos_totales  INT             NOT NULL DEFAULT 0,
    activo          TINYINT(1)      NOT NULL DEFAULT 1,
    fecha_registro  TIMESTAMP       NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (cod_manager)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ------------------------------------------------------------
-- Tabla: jugadores_reales  (equivalente a: heroes / vehiculos)
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS jugadores_reales (
    id              INT             NOT NULL AUTO_INCREMENT,
    nombre          VARCHAR(100)    NOT NULL,
    club            VARCHAR(100)    NOT NULL,
    posicion        ENUM('Portero','Defensa','Centrocampista','Delantero') NOT NULL,
    precio          INT             NOT NULL DEFAULT 5,
    puntos_media    DECIMAL(4,1)    NOT NULL DEFAULT 5.0,
    nacionalidad    VARCHAR(50)     NOT NULL DEFAULT 'España',
    estado          ENUM('Disponible','Fichado','Lesionado') NOT NULL DEFAULT 'Disponible',
    imagen_url      VARCHAR(500)    NOT NULL DEFAULT '',
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ------------------------------------------------------------
-- Tabla: jornadas  (equivalente a: misiones / clases)
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS jornadas (
    id              INT             NOT NULL AUTO_INCREMENT,
    numero          INT             NOT NULL,
    descripcion     VARCHAR(255)    NOT NULL DEFAULT '',
    fecha_inicio    DATE            NOT NULL,
    fecha_fin       DATE            NOT NULL,
    slots_max       INT             NOT NULL DEFAULT 11,
    presupuesto_max INT             NOT NULL DEFAULT 100,
    estado          ENUM('Abierta','Cerrada','Finalizada') NOT NULL DEFAULT 'Abierta',
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ------------------------------------------------------------
-- Tabla: plantilla  (equivalente a: asignaciones / reservas)
-- Manager ficha a un jugador para una jornada
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS plantilla (
    id              INT             NOT NULL AUTO_INCREMENT,
    cod_manager     VARCHAR(10)     NOT NULL,
    id_jugador      INT             NOT NULL,
    id_jornada      INT             NOT NULL,
    fecha_fichaje   TIMESTAMP       NOT NULL DEFAULT CURRENT_TIMESTAMP,
    estado          ENUM('Activo','Cancelado') NOT NULL DEFAULT 'Activo',
    PRIMARY KEY (id),
    FOREIGN KEY (cod_manager) REFERENCES managers(cod_manager)        ON DELETE CASCADE,
    FOREIGN KEY (id_jugador)  REFERENCES jugadores_reales(id)         ON DELETE CASCADE,
    FOREIGN KEY (id_jornada)  REFERENCES jornadas(id)                 ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================================
--  DATOS DE PRUEBA
-- ============================================================

-- Hash bcrypt de "1234" — genera el tuyo con password_hash('1234', PASSWORD_BCRYPT)
INSERT INTO managers (cod_manager, nombre, apellidos, pin, liga, puntos_totales, activo) VALUES
('MAN-001', 'Rubén',   'Molina García',    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Diamante', 1250, 1),
('MAN-002', 'Elena',   'Torres Vega',      '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Oro',       980, 1),
('MAN-003', 'Carlos',  'Ruiz Sánchez',     '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Plata',     540, 1),
('MAN-004', 'Baneado', 'Usuario Inactivo', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Bronce',      0, 0);

INSERT INTO jugadores_reales (nombre, club, posicion, precio, puntos_media, nacionalidad, estado, imagen_url) VALUES
('Ter Stegen',       'FC Barcelona',      'Portero',         8,  7.2, 'Alemania',   'Disponible', 'https://i.imgur.com/abc1.png'),
('Thibaut Courtois', 'Real Madrid',       'Portero',         9,  7.8, 'Bélgica',    'Disponible', 'https://i.imgur.com/abc2.png'),
('Carvajal',         'Real Madrid',       'Defensa',         7,  6.9, 'España',     'Disponible', 'https://i.imgur.com/abc3.png'),
('Alejandro Balde',  'FC Barcelona',      'Defensa',         7,  7.1, 'España',     'Disponible', 'https://i.imgur.com/abc4.png'),
('Pedri',            'FC Barcelona',      'Centrocampista',  10, 8.5, 'España',     'Disponible', 'https://i.imgur.com/abc5.png'),
('Vinícius Jr.',     'Real Madrid',       'Delantero',       12, 9.1, 'Brasil',     'Fichado',    'https://i.imgur.com/abc6.png'),
('Lamine Yamal',     'FC Barcelona',      'Delantero',       11, 8.9, 'España',     'Disponible', 'https://i.imgur.com/abc7.png'),
('Bellingham',       'Real Madrid',       'Centrocampista',  11, 8.7, 'Inglaterra', 'Disponible', 'https://i.imgur.com/abc8.png'),
('Araujo',           'FC Barcelona',      'Defensa',          8, 7.3, 'Uruguay',    'Lesionado',  'https://i.imgur.com/abc9.png'),
('Morata',           'Atlético de Madrid','Delantero',        9, 7.6, 'España',     'Disponible', 'https://i.imgur.com/abcA.png'),
('De Paul',          'Atlético de Madrid','Centrocampista',   8, 7.0, 'Argentina',  'Disponible', 'https://i.imgur.com/abcB.png'),
('Griezmann',        'Atlético de Madrid','Delantero',       10, 8.2, 'Francia',    'Disponible', 'https://i.imgur.com/abcC.png');

INSERT INTO jornadas (numero, descripcion, fecha_inicio, fecha_fin, slots_max, presupuesto_max, estado) VALUES
(28, 'Jornada 28 — Semana de clásicos y derbis', '2025-03-15', '2025-03-17', 11, 100, 'Abierta'),
(29, 'Jornada 29 — Partidos de media semana',    '2025-03-22', '2025-03-24', 11, 100, 'Abierta'),
(30, 'Jornada 30 — Vuelta de Champions',         '2025-03-29', '2025-03-31', 11, 100, 'Abierta'),
(27, 'Jornada 27 — Ya cerrada',                  '2025-03-08', '2025-03-10', 11, 100, 'Cerrada'),
(26, 'Jornada 26 — Finalizada',                  '2025-03-01', '2025-03-03', 11, 100, 'Finalizada');

INSERT INTO plantilla (cod_manager, id_jugador, id_jornada, estado) VALUES
('MAN-001', 6, 1, 'Activo'),
('MAN-002', 5, 1, 'Activo'),
('MAN-001', 8, 2, 'Activo'),
('MAN-003', 7, 1, 'Cancelado');

-- ============================================================
-- CREDENCIALES DE PRUEBA
-- Actualiza el hash con: password_hash('1234', PASSWORD_BCRYPT)
-- Credencial: MAN-001-1234
-- ============================================================

UPDATE managers SET pin = '$2y$10$jKjp1XnC4XdrCQSdU/MjXuZZB/fwyeOH/WYaIAwAPVMwsZLK4QHEu' WHERE cod_manager = 'MAN-001';
