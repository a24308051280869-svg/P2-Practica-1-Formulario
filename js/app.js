/* ==========================================================================
   app.js  ·  FUNCIONES DE INTERFAZ COMPARTIDAS
   --------------------------------------------------------------------------
   Se carga en todas las páginas. Se encarga de:
     - el botón de la esquina (Iniciar sesión / Hola, Nombre + Salir)
     - los mensajes verdes y rojos (avisos de éxito o error)
     - dibujar las tarjetas de producto con su foto
   ========================================================================== */


/* Convierte caracteres especiales (< > & " ') en texto seguro.
   Se usa siempre que se mete texto de la base de datos dentro del HTML. */
function esc(t) {
  return String(t).replace(/[&<>"']/g, c => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c]));
}


/* ---------- Botón de sesión (esquina superior derecha) ----------
   Si hay un usuario con sesión iniciada muestra "Hola, Nombre" y "Salir";
   si no, muestra el botón rojo "Iniciar sesión". */
function pintarSesion() {
  const cont = document.getElementById('session');   // contenedor en la barra de navegación
  if (!cont) return;
  const u = usuarioActual();
  cont.innerHTML = u
    ? `<span class="hello">Hola, ${esc(u.nombre)}</span><a class="btn btn-outline" href="#" id="btn-salir">Salir</a>`
    : `<a class="btn btn-red" href="login.html">Iniciar sesión</a>`;

  // Al pulsar "Salir": cerrar sesión, dejar un aviso y volver al inicio
  const salir = document.getElementById('btn-salir');
  if (salir) salir.addEventListener('click', e => {
    e.preventDefault();
    cerrarSesion();
    guardarMensaje('Sesión cerrada.', 'ok');
    location.href = 'index.html';
  });
}


/* ---------- Mensajes de aviso ----------
   tipo = 'ok' (verde) o 'error' (rojo). */

/* Guarda un mensaje para mostrarlo en la SIGUIENTE página
   (por ejemplo, "Cuenta creada" justo después de registrarse). */
function guardarMensaje(texto, tipo) {
  sessionStorage.setItem('hf_msg', JSON.stringify({ texto, tipo }));
}

/* Muestra un mensaje ahora mismo en la página actual */
function mostrarMensaje(texto, tipo) {
  const cont = document.getElementById('flashes');
  if (!cont) return;
  cont.innerHTML += `<div class="flash ${tipo}">${esc(texto)}</div>`;
}

/* Al cargar una página, muestra el mensaje que dejó la página anterior (si hay) */
function mostrarMensajeGuardado() {
  const m = sessionStorage.getItem('hf_msg');
  if (!m) return;
  sessionStorage.removeItem('hf_msg');       // se muestra una sola vez
  const { texto, tipo } = JSON.parse(m);
  mostrarMensaje(texto, tipo);
}


/* ---------- Tarjeta de producto ----------
   Recibe una fila de la tabla productos y devuelve el HTML de su tarjeta.
   La foto sale del archivo indicado en la columna "imagen". Si el archivo
   no existe, onerror="this.remove()" quita la foto rota y se ve el fondo
   rojo/negro de respaldo definido en style.css. */
function tarjetaProducto(p) {
  const precio = Number(p.precio).toLocaleString('es-MX', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
  const stock = p.stock > 0
    ? `<span class="stock ok">${p.stock} disponibles</span>`
    : `<span class="stock out">Agotado</span>`;
  const foto = p.imagen
    ? `<img src="${esc(p.imagen)}" alt="${esc(p.nombre)}" loading="lazy" onerror="this.remove()">`
    : '';
  return `
  <article class="product">
    <div class="product-img cat-${esc(p.categoria.toLowerCase())}">
      ${foto}
      <span class="tag">${esc(p.categoria)}</span>
      <span class="hero-name">${esc(p.heroe)}</span>
    </div>
    <div class="product-body">
      <h3>${esc(p.nombre)}</h3>
      <p>${esc(p.descripcion)}</p>
      <div class="product-foot">
        <span class="price">$${precio} <small>MXN</small></span>
        ${stock}
      </div>
    </div>
  </article>`;
}


/* ---------- FUNCIÓN footer() · PIE DE PÁGINA ----------
   Dibuja el pie de página dentro de <footer id="footer"> (que existe vacío en
   las 4 páginas). Así el pie se escribe UNA sola vez aquí, y cualquier cambio
   se refleja en todo el sitio. Contiene solo:
     - el logo (img/logo.png) y el nombre KEVLAR
     - el código MME-0869 */
function footer() {
  const pie = document.getElementById('footer');
  if (!pie) return;
  pie.innerHTML = `
    <div class="footer-inner">
      <div class="logo small">
        <img class="logo-img" src="img/logo.png" alt="Logo de KEVLAR">
        <b>KEV<span>LAR</span></b>
      </div>
      <span class="folio">MME-0869</span>
    </div>`;
}


/* Al terminar de cargar cualquier página: dibujar el botón de sesión,
   el pie de página y mostrar mensajes pendientes. */
document.addEventListener('DOMContentLoaded', () => {
  pintarSesion();
  footer();
  mostrarMensajeGuardado();
});
