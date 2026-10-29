<?php
// CATÁLOGO: aquí se muestra todo lo que vendemos

include "conexion.php";
include "funciones.php";

$titulo = "Catálogo";
$pagina = "catalogo";
include "encabezado.php";

// Si en la dirección viene ?categoria=Trajes, solo muestro esa categoría
$categoria = "";
if (isset($_GET['categoria'])) {
    $categoria = $_GET['categoria'];
}
?>

<section class="encabezado-pagina">
    <div class="contenido">
        <h1>Catá<span class="rojo-texto">logo</span></h1>
        <p>Trajes, armas de utilería y accesorios. Todo listo para tu próxima misión.</p>
    </div>
</section>

<section class="seccion">
    <div class="contenido">

        <!-- Botones para filtrar por categoría -->
        <div class="filtros">
            <a href="catalogo.php" <?php if ($categoria == '') echo 'class="activo"'; ?>>Todo</a>
            <a href="catalogo.php?categoria=Trajes" <?php if ($categoria == 'Trajes') echo 'class="activo"'; ?>>Trajes</a>
            <a href="catalogo.php?categoria=Armas" <?php if ($categoria == 'Armas') echo 'class="activo"'; ?>>Armas (utilería)</a>
            <a href="catalogo.php?categoria=Accesorios" <?php if ($categoria == 'Accesorios') echo 'class="activo"'; ?>>Accesorios</a>
        </div>

        <div class="productos">
            <?php
            if ($categoria == '') {
                // Sin filtro: traigo todos los productos
                $resultado = mysqli_query($conexion, "SELECT * FROM productos ORDER BY heroe, nombre");
            } else {
                // Con filtro: uso "?" y después le pongo el valor (así nadie puede meter código raro)
                $consulta = mysqli_prepare($conexion, "SELECT * FROM productos WHERE categoria = ? ORDER BY heroe, nombre");
                mysqli_stmt_bind_param($consulta, "s", $categoria);
                mysqli_stmt_execute($consulta);
                $resultado = mysqli_stmt_get_result($consulta);
            }

            // Dibujo una tarjeta por cada producto
            while ($fila = mysqli_fetch_assoc($resultado)) {
                tarjeta($fila);
            }
            ?>
        </div>

    </div>
</section>

<?php footer(); ?>
</body>
</html>
