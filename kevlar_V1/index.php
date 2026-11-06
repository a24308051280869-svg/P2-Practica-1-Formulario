<?php
// INICIO: la página principal (portada y quiénes somos)

include "conexion.php";
include "funciones.php";

$titulo = "Inicio";
$pagina = "inicio";
include "encabezado.php";
?>

<!-- ===== PORTADA: título grande y botones (la foto de fondo se cambia en el css, en .portada) ===== -->
<section class="portada">
    <div class="contenido">
        <p class="pequeno">Tienda de trajes y accesorios</p>
        <h1>Hecho para<br><span class="rojo-texto">resistir.</span></h1>
        <p class="texto-portada">Trajes de cuerpo completo, réplicas de utilería y accesorios para cosplay, coleccionistas y fans que no se conforman con lo común.</p>
        <a class="boton rojo grande" href="catalogo.php">Ver catálogo</a>
        <a class="boton blanco grande" href="registrar.php">Crear cuenta</a>
    </div>
</section>

<!-- ===== QUIÉNES SOMOS: las 3 cajitas ===== -->
<section class="seccion">
    <div class="contenido">
        <h2>Quiénes <span class="rojo-texto">somos</span></h2>
        <div class="cajas">
            <div class="caja">
                <h3>Nuestra misión</h3>
                <p>En KEVLAR hacemos que cualquier fan pueda ponerse el traje de su héroe favorito con calidad profesional, sin pagar de más.</p>
            </div>
            <div class="caja">
                <h3>Hecho con detalle</h3>
                <p>Telas elásticas, costuras reforzadas y acabados pensados para durar convenciones, sesiones de fotos y noches de patrullaje.</p>
            </div>
            <div class="caja">
                <h3>Envíos y soporte</h3>
                <p>Atención personalizada, guía de tallas y envíos a todo el país. Tu pedido llega listo para la acción.</p>
            </div>
        </div>
    </div>
</section>

<?php footer(); ?>
</body>
</html>
