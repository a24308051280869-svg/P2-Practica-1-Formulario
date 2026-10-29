<?php
// Aquí puse las funciones para no repetir el mismo código en todas las páginas.

// Función que dibuja el pie de página (solo logo, nombre y MME-0869)
function footer() {
    echo '
    <footer class="footer">
        <div class="footer-contenido">
            <div class="logo">
                <img src="img/logo.png" alt="Logo de KEVLAR">
                <span>KEV<b>LAR</b></span>
            </div>
            <span class="folio">MME-0869</span>
        </div>
    </footer>';
}

// Función que dibuja una tarjeta con un producto
// $p es una fila de la tabla productos (una fila = un producto)
function tarjeta($p) {
    $precio = number_format($p['precio'], 2);   // 3499 -> 3,499.00

    // Si hay piezas muestro cuántas, si no, "Agotado"
    if ($p['stock'] > 0) {
        $stock = '<span class="stock">' . $p['stock'] . ' disponibles</span>';
    } else {
        $stock = '<span class="stock agotado">Agotado</span>';
    }

    // htmlspecialchars sirve para que el texto no rompa la página
    echo '
    <div class="producto">
        <div class="foto">
            <img src="' . htmlspecialchars($p['imagen']) . '" alt="" onerror="this.style.display=\'none\'">
            <span class="etiqueta">' . htmlspecialchars($p['categoria']) . '</span>
            <span class="heroe">' . htmlspecialchars($p['heroe']) . '</span>
        </div>
        <div class="info">
            <h3>' . htmlspecialchars($p['nombre']) . '</h3>
            <p>' . htmlspecialchars($p['descripcion']) . '</p>
            <div class="pie-producto">
                <span class="precio">$' . $precio . ' MXN</span>
                ' . $stock . '
            </div>
        </div>
    </div>';
}
