-- =====================================================
--  BASE DE DATOS DE LA TIENDA KEVLAR
--  Para usarla: abrir phpMyAdmin -> pestaña "Importar"
--  -> elegir este archivo -> darle al botón "Importar"
-- =====================================================

-- Creo la base de datos (si ya existe, no pasa nada)
CREATE DATABASE IF NOT EXISTS kevlar CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;

-- Le digo que voy a trabajar dentro de la base kevlar
USE kevlar;

-- Tabla donde se guardan las personas que se registran
CREATE TABLE IF NOT EXISTS usuarios (
    id         INT AUTO_INCREMENT PRIMARY KEY,   -- número que se pone solo (1, 2, 3...)
    nombre     VARCHAR(60)  NOT NULL,
    apellido   VARCHAR(60)  NOT NULL,
    correo     VARCHAR(120) NOT NULL UNIQUE,     -- UNIQUE = no se puede repetir el correo
    telefono   VARCHAR(20),                      -- puede quedar vacío
    contrasena VARCHAR(255) NOT NULL,            -- aquí se guarda la contraseña ya cifrada
    fecha      TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabla con todo lo que vendemos
CREATE TABLE IF NOT EXISTS productos (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    nombre      VARCHAR(100) NOT NULL,
    descripcion TEXT         NOT NULL,
    categoria   VARCHAR(30)  NOT NULL,           -- Trajes, Armas o Accesorios
    heroe       VARCHAR(30)  NOT NULL,
    precio      DECIMAL(10,2) NOT NULL,
    stock       INT NOT NULL,                    -- cuántos hay disponibles
    imagen      VARCHAR(150)                     -- ruta de la foto
);

-- Productos que ya vienen en la tienda
INSERT INTO productos (nombre, descripcion, categoria, heroe, precio, stock, imagen) VALUES
('Traje Daredevil Rojo', 'Traje completo estilo vigilante rojo, tela elástica con refuerzos acolchados. Incluye capucha.', 'Trajes', 'Daredevil', 3499, 12, 'img/productos/traje-daredevil-rojo.jpg'),
('Traje Daredevil Negro Táctico', 'Versión oscura con paneles reforzados, ideal para cosplay y coleccionistas.', 'Trajes', 'Daredevil', 3899, 8, 'img/productos/traje-daredevil-negro.jpg'),
('Bastón de Combate (réplica)', 'Réplica de utilería en dos piezas con cuerda decorativa. No apto para combate real.', 'Armas', 'Daredevil', 1299, 20, 'img/productos/baston-combate.jpg'),
('Máscara Daredevil', 'Máscara de tela rígida con ajuste trasero y detalles en relieve.', 'Accesorios', 'Daredevil', 699, 25, 'img/productos/mascara-daredevil.jpg'),
('Traje Spider-Man Clásico', 'Traje de cuerpo completo con textura de red impresa y máscara con lentes removibles.', 'Trajes', 'Spider-Man', 3299, 15, 'img/productos/traje-spiderman-clasico.jpg'),
('Traje Spider-Man Edición Negra', 'Edición especial en negro y rojo con acabado mate.', 'Trajes', 'Spider-Man', 3799, 7, 'img/productos/traje-spiderman-negro.jpg'),
('Lanzarredes de Muñeca (réplica)', 'Par de lanzadores de utilería con correa ajustable. Sin mecanismo de disparo.', 'Armas', 'Spider-Man', 899, 30, 'img/productos/lanzarredes.jpg'),
('Guantes Tácticos Negros', 'Guantes reforzados con nudillos acolchados, compatibles con varios trajes.', 'Accesorios', 'Universal', 549, 40, 'img/productos/guantes-tacticos.jpg'),
('Cinturón Utilitario', 'Cinturón de cuero sintético con bolsas y hebilla metálica roja.', 'Accesorios', 'Universal', 799, 18, 'img/productos/cinturon-utilitario.jpg');
