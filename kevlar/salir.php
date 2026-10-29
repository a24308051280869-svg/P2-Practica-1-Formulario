<?php
// CERRAR SESIÓN: borro lo que se guardó de la persona y regreso al inicio
session_start();
session_destroy();
header("Location: index.php");
exit;
