<?php
// Este archivo se incluye al inicio de todas las páginas.
// Sirve para dos cosas: iniciar la sesión y conectarme a la base de datos.

// Con esto el sitio se acuerda de quién inició sesión
session_start();

// Me conecto con los datos de XAMPP: servidor, usuario, contraseña (vacía) y nombre de la base.
// Uso try/catch para que, si MySQL está apagado, salga un mensaje fácil de entender.
try {
    $conexion = mysqli_connect("localhost", "root", "", "kevlar");
} catch (Exception $e) {
    die("No me pude conectar a la base de datos. ¿Está prendido MySQL en XAMPP? ¿Ya importé base_de_datos.sql?");
}

// Para que se vean bien los acentos y la ñ
mysqli_set_charset($conexion, "utf8mb4");
