<?php
// CATÁLOGO: aquí están TODOS los productos en un solo archivo.
// No vienen de la base de datos: están escritos aquí mismo, en la lista de abajo.

include "conexion.php";
include "funciones.php";

$titulo = "Catálogo";
$pagina = "catalogo";
include "encabezado.php";

// LISTA DE PRODUCTOS: cada línea es un producto (nombre, descripción, categoría, héroe, precio y foto).
// Para agregar uno nuevo, copio una línea y cambio los datos.
$productos = array(
    // ---------- Trajes ----------
    array('nombre' => 'Traje Daredevil Rojo', 'descripcion' => 'Traje completo estilo vigilante rojo, tela elástica con refuerzos acolchados. Incluye capucha.', 'categoria' => 'Trajes', 'heroe' => 'Daredevil', 'precio' => 3499, 'imagen' => 'img/productos/traje-daredevil-rojo.jpg'),
    array('nombre' => 'Traje Daredevil Negro Táctico', 'descripcion' => 'Versión oscura con paneles reforzados, ideal para cosplay y coleccionistas.', 'categoria' => 'Trajes', 'heroe' => 'Daredevil', 'precio' => 3899, 'imagen' => 'img/productos/traje-daredevil-negro.jpg'),
    array('nombre' => 'Traje Daredevil Armadura Blindada', 'descripcion' => 'Traje con placas rígidas de espuma EVA en pecho y hombros, acabado rojo oscuro.', 'categoria' => 'Trajes', 'heroe' => 'Daredevil', 'precio' => 4299, 'imagen' => 'img/productos/traje-daredevil-armadura.jpg'),
    array('nombre' => 'Traje Spider-Man Clásico', 'descripcion' => 'Traje de cuerpo completo con textura de red impresa y máscara con lentes removibles.', 'categoria' => 'Trajes', 'heroe' => 'Spider-Man', 'precio' => 3299, 'imagen' => 'img/productos/traje-spiderman-clasico.jpg'),
    array('nombre' => 'Traje Spider-Man Edición Negra', 'descripcion' => 'Edición especial en negro y rojo con acabado mate.', 'categoria' => 'Trajes', 'heroe' => 'Spider-Man', 'precio' => 3799, 'imagen' => 'img/productos/traje-spiderman-negro.jpg'),
    array('nombre' => 'Traje Spider-Man Iron Spider', 'descripcion' => 'Traje rojo y dorado con detalles metálicos impresos y patas decorativas para la espalda.', 'categoria' => 'Trajes', 'heroe' => 'Spider-Man', 'precio' => 4499, 'imagen' => 'img/productos/traje-spiderman-iron.jpg'),
    array('nombre' => 'Traje Spider-Man Infantil', 'descripcion' => 'Traje de cuerpo completo en tallas infantiles, tela suave y cierre trasero.', 'categoria' => 'Trajes', 'heroe' => 'Spider-Man', 'precio' => 1999, 'imagen' => 'img/productos/traje-spiderman-infantil.jpg'),
    array('nombre' => 'Traje Punisher Táctico', 'descripcion' => 'Chamarra y pantalón negros con calavera blanca estampada en el pecho.', 'categoria' => 'Trajes', 'heroe' => 'Punisher', 'precio' => 3599, 'imagen' => 'img/productos/traje-punisher.jpg'),
    array('nombre' => 'Traje Black Panther', 'descripcion' => 'Traje negro con líneas plateadas texturizadas y capucha con orejas.', 'categoria' => 'Trajes', 'heroe' => 'Black Panther', 'precio' => 3999, 'imagen' => 'img/productos/traje-blackpanther.jpg'),
    array('nombre' => 'Traje Vigilante Urbano Rojo y Negro', 'descripcion' => 'Traje original sin licencia, tela elástica bicolor pensado para cosplay libre.', 'categoria' => 'Trajes', 'heroe' => 'Universal', 'precio' => 2899, 'imagen' => 'img/productos/traje-vigilante.jpg'),

    // ---------- Armas de utilería ----------
    array('nombre' => 'Bastón de Combate (réplica)', 'descripcion' => 'Réplica de utilería en dos piezas con cuerda decorativa. No apto para combate real.', 'categoria' => 'Armas', 'heroe' => 'Daredevil', 'precio' => 1299, 'imagen' => 'img/productos/baston-combate.jpg'),
    array('nombre' => 'Bastón Doble de Entrenamiento', 'descripcion' => 'Par de bastones de espuma rígida para sesiones de foto y desfiles.', 'categoria' => 'Armas', 'heroe' => 'Daredevil', 'precio' => 1599, 'imagen' => 'img/productos/baston-doble.jpg'),
    array('nombre' => 'Cuerda con Gancho (réplica)', 'descripcion' => 'Cuerda decorativa de 2 m con gancho de plástico. Solo utilería.', 'categoria' => 'Armas', 'heroe' => 'Daredevil', 'precio' => 749, 'imagen' => 'img/productos/cuerda-gancho.jpg'),
    array('nombre' => 'Lanzarredes de Muñeca (réplica)', 'descripcion' => 'Par de lanzadores de utilería con correa ajustable. Sin mecanismo de disparo.', 'categoria' => 'Armas', 'heroe' => 'Spider-Man', 'precio' => 899, 'imagen' => 'img/productos/lanzarredes.jpg'),
    array('nombre' => 'Lanzarredes con Luz LED', 'descripcion' => 'Lanzador de utilería con luz LED azul en la muñequera. Incluye pilas.', 'categoria' => 'Armas', 'heroe' => 'Spider-Man', 'precio' => 1199, 'imagen' => 'img/productos/lanzarredes-led.jpg'),
    array('nombre' => 'Pistola Punisher (réplica de espuma)', 'descripcion' => 'Réplica de espuma suave tamaño real, sin funcionamiento. Para exhibición.', 'categoria' => 'Armas', 'heroe' => 'Punisher', 'precio' => 999, 'imagen' => 'img/productos/pistola-punisher.jpg'),
    array('nombre' => 'Rifle Táctico de Utilería', 'descripcion' => 'Rifle de espuma EVA pintado a mano. Solo para cosplay, nunca para uso real.', 'categoria' => 'Armas', 'heroe' => 'Punisher', 'precio' => 1799, 'imagen' => 'img/productos/rifle-tactico.jpg'),
    array('nombre' => 'Garras de Vibranium (réplica)', 'descripcion' => 'Par de garras plásticas plateadas con guantes ajustables.', 'categoria' => 'Armas', 'heroe' => 'Black Panther', 'precio' => 1099, 'imagen' => 'img/productos/garras-vibranium.jpg'),
    array('nombre' => 'Lanza Ceremonial (réplica)', 'descripcion' => 'Lanza de utilería de 1.5 m, desarmable en tres piezas.', 'categoria' => 'Armas', 'heroe' => 'Black Panther', 'precio' => 1399, 'imagen' => 'img/productos/lanza-ceremonial.jpg'),
    array('nombre' => 'Escudo de Utilería Táctico', 'descripcion' => 'Escudo circular de espuma y tela, con correas internas. Sin uso real.', 'categoria' => 'Armas', 'heroe' => 'Universal', 'precio' => 1499, 'imagen' => 'img/productos/escudo-tactico.jpg'),

    // ---------- Accesorios ----------
    array('nombre' => 'Máscara Daredevil', 'descripcion' => 'Máscara de tela rígida con ajuste trasero y detalles en relieve.', 'categoria' => 'Accesorios', 'heroe' => 'Daredevil', 'precio' => 699, 'imagen' => 'img/productos/mascara-daredevil.jpg'),
    array('nombre' => 'Máscara Spider-Man', 'descripcion' => 'Máscara de tela elástica con lentes removibles y buena ventilación.', 'categoria' => 'Accesorios', 'heroe' => 'Spider-Man', 'precio' => 649, 'imagen' => 'img/productos/mascara-spiderman.jpg'),
    array('nombre' => 'Máscara Punisher Calavera', 'descripcion' => 'Pasamontañas negro con calavera blanca estampada.', 'categoria' => 'Accesorios', 'heroe' => 'Punisher', 'precio' => 399, 'imagen' => 'img/productos/mascara-punisher.jpg'),
    array('nombre' => 'Máscara Black Panther', 'descripcion' => 'Máscara de espuma moldeada con detalles plateados.', 'categoria' => 'Accesorios', 'heroe' => 'Black Panther', 'precio' => 799, 'imagen' => 'img/productos/mascara-blackpanther.jpg'),
    array('nombre' => 'Guantes Tácticos Negros', 'descripcion' => 'Guantes reforzados con nudillos acolchados, compatibles con varios trajes.', 'categoria' => 'Accesorios', 'heroe' => 'Universal', 'precio' => 549, 'imagen' => 'img/productos/guantes-tacticos.jpg'),
    array('nombre' => 'Cinturón Utilitario', 'descripcion' => 'Cinturón de cuero sintético con bolsas y hebilla metálica roja.', 'categoria' => 'Accesorios', 'heroe' => 'Universal', 'precio' => 799, 'imagen' => 'img/productos/cinturon-utilitario.jpg'),
    array('nombre' => 'Botas Tácticas Negras', 'descripcion' => 'Botas de caña media con suela antiderrapante. Varias tallas.', 'categoria' => 'Accesorios', 'heroe' => 'Universal', 'precio' => 1499, 'imagen' => 'img/productos/botas-tacticas.jpg'),
    array('nombre' => 'Mochila Táctica Roja', 'descripcion' => 'Mochila de 30 litros con compartimentos y correas reforzadas.', 'categoria' => 'Accesorios', 'heroe' => 'Universal', 'precio' => 999, 'imagen' => 'img/productos/mochila-tactica.jpg'),
    array('nombre' => 'Rodilleras y Coderas Tácticas', 'descripcion' => 'Set de protecciones acolchadas para sesiones de foto y eventos.', 'categoria' => 'Accesorios', 'heroe' => 'Universal', 'precio' => 649, 'imagen' => 'img/productos/rodilleras.jpg'),
    array('nombre' => 'Gabardina Vigilante', 'descripcion' => 'Gabardina larga negra con forro rojo, ideal para complementar un cosplay.', 'categoria' => 'Accesorios', 'heroe' => 'Universal', 'precio' => 1899, 'imagen' => 'img/productos/gabardina-vigilante.jpg'),
);
?>

<!-- ===== TÍTULO DE LA PÁGINA ===== -->
<section class="encabezado-pagina">
    <div class="contenido">
        <h1>Catá<span class="rojo-texto">logo</span></h1>
        <p>Trajes, armas de utilería y accesorios. Todo listo para tu próxima misión.</p>
    </div>
</section>

<!-- ===== TODOS LOS PRODUCTOS ===== -->
<section class="seccion">
    <div class="contenido">
        <div class="productos">
            <?php
            // Por cada producto de la lista dibujo una tarjeta (la función tarjeta() está en funciones.php)
            foreach ($productos as $producto) {
                tarjeta($producto);
            }
            ?>
        </div>
    </div>
</section>

<?php footer(); ?>
</body>
</html>
