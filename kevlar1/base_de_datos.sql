-- =====================================================
--  BASE DE DATOS DE LA TIENDA KEVLAR
--  Para usarla: abrir phpMyAdmin -> pestaña "Importar"
--  -> elegir este archivo -> darle al botón "Importar"
--  Solo guarda a las personas que se registran (formulario).
--  Los productos ya no están en la base de datos.
-- =====================================================

CREATE DATABASE IF NOT EXISTS kevlar CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE kevlar;

-- Tabla donde se guardan las personas que se registran
CREATE TABLE IF NOT EXISTS usuarios (
    id         INT AUTO_INCREMENT PRIMARY KEY,
    nombre     VARCHAR(60)  NOT NULL,
    apellido   VARCHAR(60)  NOT NULL,
    correo     VARCHAR(120) NOT NULL UNIQUE,
    telefono   VARCHAR(20),
    contrasena VARCHAR(255) NOT NULL,
    fecha      TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Quito la tabla de productos si ya existía (la tabla usuarios NO se borra)
DROP TABLE IF EXISTS productos;
