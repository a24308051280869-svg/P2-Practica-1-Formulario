<?php
// ENCABEZADO: la parte de arriba de TODAS las páginas (el head y el menú).
// Antes de incluirlo, cada página tiene que definir $titulo y $pagina.
// $titulo = lo que sale en la pestaña del navegador
// $pagina = cuál link del menú se marca en rojo
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $titulo; ?> - KEVLAR</title>
    <link rel="icon" href="img/logo.png">
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>

<!-- ===== MENÚ DE ARRIBA ===== -->
<header class="barra">
    <div class="barra-contenido">

        <!-- Logo y nombre -->
        <a class="logo" href="index.php">
            <img src="img/logo.png" alt="Logo de KEVLAR">
            <span>KEV<b>LAR</b></span>
        </a>

        <!-- Links del menú. El de la página donde estoy lleva la clase "activo" (se marca en rojo) -->
        <nav class="menu">
            <a href="index.php"    <?php if ($pagina == 'inicio')   echo 'class="activo"'; ?>>Inicio</a>
            <a href="catalogo.php" <?php if ($pagina == 'catalogo') echo 'class="activo"'; ?>>Catálogo</a>
            <a href="registrar.php" <?php if ($pagina == 'registrar') echo 'class="activo"'; ?>>Registrar</a>
        </nav>

        <!-- Esquina derecha: si ya inició sesión sale "Hola, nombre" y Salir; si no, el botón rojo -->
        <div class="sesion">
            <?php if (isset($_SESSION['nombre'])) { ?>
                <span>Hola, <?php echo htmlspecialchars($_SESSION['nombre']); ?></span>
                <a class="boton blanco" href="salir.php">Salir</a>
            <?php } else { ?>
                <a class="boton rojo" href="login.php">Iniciar sesión</a>
            <?php } ?>
        </div>

    </div>
</header>
