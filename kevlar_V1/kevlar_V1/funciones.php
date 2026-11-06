<?php
// FUNCIONES: cosas que se repiten en varias páginas.
// Aquí están: footer() = el pie de página, tarjeta() = la cajita de cada producto.

// ---------- FOOTER: el pie de página (logo, nombre y MME-0869) ----------
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

// ---------- TARJETA: la cajita de un producto (foto, nombre, descripción y precio) ----------
// $p es un producto de la lista que está en catalogo.php
function tarjeta($p) {
    $precio = number_format($p['precio'], 2);   // 3499 se ve como 3,499.00

    // htmlspecialchars: para que los textos no rompan la página
    // Si la foto no existe, se oculta y se ve el fondo rojo
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
            </div>
        </div>
    </div>';
}
