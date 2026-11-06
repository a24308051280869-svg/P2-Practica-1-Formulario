-- =====================================================
--  BASE DE DATOS DE KEVLAR (versión 1)
--  Para usarla: phpMyAdmin -> pestaña "Importar"
--  -> elegir este archivo -> botón "Importar"
--  Solo tiene la tabla de usuarios (la del formulario).
--  Los productos NO están aquí, están en catalogo.php
-- =====================================================

-- Crea la base de datos (si ya existe, no pasa nada)
CREATE DATABASE IF NOT EXISTS kevlar_V1 CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;

-- Me meto a esa base
USE kevlar_V1;

-- Tabla USUARIOS: aquí se guardan las personas que se registran
CREATE TABLE IF NOT EXISTS usuarios (
    id         INT AUTO_INCREMENT PRIMARY KEY,   -- número que se pone solo (1, 2, 3...)
    nombre     VARCHAR(60)  NOT NULL,
    apellido   VARCHAR(60)  NOT NULL,
    correo     VARCHAR(120) NOT NULL UNIQUE,     -- no se puede repetir
    telefono   VARCHAR(20),                      -- puede quedar vacío
    contrasena VARCHAR(255) NOT NULL,            -- se guarda tal cual, sin cifrar
    fecha      TIMESTAMP DEFAULT CURRENT_TIMESTAMP   -- cuándo se registró
);
