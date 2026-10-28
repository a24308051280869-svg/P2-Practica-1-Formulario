/* ==========================================================================
   db.js  ·  BASE DE DATOS SQL DE KEVLAR
   --------------------------------------------------------------------------
   HTML por sí solo no puede hablar con un servidor SQL, así que usamos
   sql.js: una versión de SQLite que corre dentro del navegador.
   Toda la tienda (usuarios y productos) vive en esta base de datos.
   La base se guarda en localStorage para que los datos NO se pierdan al
   cerrar o recargar la página.

   Este archivo se carga en TODAS las páginas (después de sql-wasm.js).
   ========================================================================== */


/* ---------- 1) ESQUEMA: las tablas de la base de datos ---------- */
const SCHEMA_SQL = `
-- Tabla de clientes registrados (la llena el formulario de registrar.html)
CREATE TABLE IF NOT EXISTS usuarios (
  id             INTEGER PRIMARY KEY AUTOINCREMENT,  -- número único automático
  nombre         TEXT NOT NULL,
  apellido       TEXT NOT NULL,
  email          TEXT NOT NULL UNIQUE,               -- UNIQUE: no se repite el correo
  telefono       TEXT,                               -- opcional (puede quedar vacío)
  password_hash  TEXT NOT NULL,                      -- contraseña cifrada, nunca en texto plano
  fecha_registro TEXT NOT NULL DEFAULT (datetime('now'))
);

-- Tabla de productos (la lee catalogo.html y el inicio)
CREATE TABLE IF NOT EXISTS productos (
  id          INTEGER PRIMARY KEY AUTOINCREMENT,
  nombre      TEXT NOT NULL,
  descripcion TEXT NOT NULL,
  categoria   TEXT NOT NULL,                         -- Trajes, Armas o Accesorios
  heroe       TEXT NOT NULL,
  precio      REAL NOT NULL,                         -- en pesos mexicanos
  stock       INTEGER NOT NULL DEFAULT 0,            -- piezas disponibles
  imagen      TEXT                                   -- ruta del archivo de foto
);
`;


/* ---------- 2) PRODUCTOS INICIALES ----------
   Orden de cada fila:
   [nombre, descripción, categoría, héroe, precio, stock, ARCHIVO DE FOTO]

   >>> PARA CAMBIAR UNA FOTO: guarda tu archivo en la carpeta img/productos/
       con el mismo nombre que aparece aquí (o cambia el nombre aquí).
       Si el archivo no existe, la tarjeta muestra un fondo rojo/negro
       en lugar de la foto, así que nada se rompe. */
const SEED_PRODUCTOS = [
  ['Traje Daredevil Rojo', 'Traje completo estilo vigilante rojo, tela elástica con refuerzos acolchados. Incluye capucha.', 'Trajes', 'Daredevil', 3499, 12, 'img/productos/traje-daredevil-rojo.jpg'],
  ['Traje Daredevil Negro Táctico', 'Versión oscura con paneles reforzados, ideal para cosplay y coleccionistas.', 'Trajes', 'Daredevil', 3899, 8, 'img/productos/traje-daredevil-negro.jpg'],
  ['Bastón de Combate (réplica)', 'Réplica de utilería en dos piezas con cuerda decorativa. No apto para combate real.', 'Armas', 'Daredevil', 1299, 20, 'img/productos/baston-combate.jpg'],
  ['Máscara Daredevil', 'Máscara de tela rígida con ajuste trasero y detalles en relieve.', 'Accesorios', 'Daredevil', 699, 25, 'img/productos/mascara-daredevil.jpg'],
  ['Traje Spider-Man Clásico', 'Traje de cuerpo completo con textura de red impresa y máscara con lentes removibles.', 'Trajes', 'Spider-Man', 3299, 15, 'img/productos/traje-spiderman-clasico.jpg'],
  ['Traje Spider-Man Edición Negra', 'Edición especial en negro y rojo con acabado mate.', 'Trajes', 'Spider-Man', 3799, 7, 'img/productos/traje-spiderman-negro.jpg'],
  ['Lanzarredes de Muñeca (réplica)', 'Par de lanzadores de utilería con correa ajustable. Sin mecanismo de disparo.', 'Armas', 'Spider-Man', 899, 30, 'img/productos/lanzarredes.jpg'],
  ['Guantes Tácticos Negros', 'Guantes reforzados con nudillos acolchados, compatibles con varios trajes.', 'Accesorios', 'Universal', 549, 40, 'img/productos/guantes-tacticos.jpg'],
  ['Cinturón Utilitario', 'Cinturón de cuero sintético con bolsas y hebilla metálica roja.', 'Accesorios', 'Universal', 799, 18, 'img/productos/cinturon-utilitario.jpg'],
];


/* ---------- 3) ALMACENAMIENTO EN EL NAVEGADOR ----------
   (La clave conserva el nombre antiguo a propósito, para no perder los
   usuarios que ya se registraron antes del cambio de nombre a KEVLAR.) */
const LS_DB = 'heroforge_db_v1';
let _db = null;   // aquí queda la base abierta mientras la página está cargada

/* Convierte la base (bytes) a texto para poder guardarla en localStorage */
function bytesToB64(bytes) {
  let s = '';
  for (let i = 0; i < bytes.length; i++) s += String.fromCharCode(bytes[i]);
  return btoa(s);
}
/* Hace lo contrario: del texto guardado vuelve a los bytes de la base */
function b64ToBytes(b64) {
  const s = atob(b64);
  const bytes = new Uint8Array(s.length);
  for (let i = 0; i < s.length; i++) bytes[i] = s.charCodeAt(i);
  return bytes;
}

/* Abre la base de datos. Si es la primera vez, crea las tablas y carga los
   productos. Cada página la llama con: await initDB(); */
async function initDB() {
  if (_db) return _db;                       // ya estaba abierta

  // Descarga el motor SQL (sql.js) desde internet
  const SQL = await initSqlJs({
    locateFile: f => 'https://cdnjs.cloudflare.com/ajax/libs/sql.js/1.10.3/' + f,
  });

  const guardada = localStorage.getItem(LS_DB);
  if (guardada) {
    // Ya existía una base guardada: la reabrimos con sus usuarios
    _db = new SQL.Database(b64ToBytes(guardada));
  } else {
    // Primera vez: crear tablas y meter los productos iniciales
    _db = new SQL.Database();
    _db.run(SCHEMA_SQL);
    const st = _db.prepare(
      'INSERT INTO productos (nombre, descripcion, categoria, heroe, precio, stock, imagen) VALUES (?,?,?,?,?,?,?)');
    SEED_PRODUCTOS.forEach(p => st.run(p));
    st.free();
    guardarDB();
  }

  actualizarEsquema();
  return _db;
}

/* Compatibilidad con bases creadas antes de existir la columna "imagen",
   y sincroniza las rutas de foto con la lista SEED_PRODUCTOS de arriba
   (así, cambiar un nombre de archivo ahí basta para actualizar la foto). */
function actualizarEsquema() {
  const columnas = consultar('PRAGMA table_info(productos)').map(c => c.name);
  if (!columnas.includes('imagen')) {
    _db.run('ALTER TABLE productos ADD COLUMN imagen TEXT');
    guardarDB();
  }
  SEED_PRODUCTOS.forEach(p =>
    _db.run('UPDATE productos SET imagen = ? WHERE nombre = ?', [p[6], p[0]]));
}

/* Guarda el estado actual de la base en localStorage.
   Se llama después de cada INSERT (por ejemplo, al registrar un usuario). */
function guardarDB() {
  localStorage.setItem(LS_DB, bytesToB64(_db.export()));
}

/* Ejecuta un SELECT y devuelve las filas como una lista de objetos.
   Los "?" del SQL se reemplazan por los valores de params (evita inyección SQL). */
function consultar(sql, params = []) {
  const st = _db.prepare(sql);
  st.bind(params);
  const filas = [];
  while (st.step()) filas.push(st.getAsObject());
  st.free();
  return filas;
}


/* ---------- 4) CONTRASEÑAS ----------
   Nunca se guarda la contraseña real: se guarda su "huella" SHA-256.
   Al iniciar sesión se calcula la huella de lo escrito y se compara. */
async function hashPassword(pw) {
  if (window.crypto && crypto.subtle) {
    const buf = await crypto.subtle.digest('SHA-256', new TextEncoder().encode(pw));
    return Array.from(new Uint8Array(buf)).map(b => b.toString(16).padStart(2, '0')).join('');
  }
  // Respaldo sencillo por si el navegador no ofrece crypto.subtle
  let h = 5381;
  for (let i = 0; i < pw.length; i++) h = ((h << 5) + h + pw.charCodeAt(i)) | 0;
  return 'x' + (h >>> 0).toString(16);
}


/* ---------- 5) OPERACIONES DE LA TIENDA ---------- */

/* Productos del catálogo; si se indica categoría, filtra por ella */
function listarProductos(categoria) {
  if (categoria) {
    return consultar('SELECT * FROM productos WHERE categoria = ? ORDER BY heroe, nombre', [categoria]);
  }
  return consultar('SELECT * FROM productos ORDER BY heroe, nombre');
}

/* Los 3 productos más caros, para la sección "Lo más destacado" del inicio */
function destacados() {
  return consultar('SELECT * FROM productos ORDER BY precio DESC LIMIT 3');
}

/* REGISTRO: comprueba que el correo no exista y guarda al usuario (INSERT) */
async function registrarUsuario({ nombre, apellido, email, telefono, password }) {
  const existe = consultar('SELECT id FROM usuarios WHERE email = ?', [email]);
  if (existe.length) return { ok: false, error: 'Ese correo ya está registrado.' };

  const hash = await hashPassword(password);
  _db.run(
    'INSERT INTO usuarios (nombre, apellido, email, telefono, password_hash) VALUES (?,?,?,?,?)',
    [nombre, apellido, email, telefono || null, hash]);
  guardarDB();                               // persistir el nuevo usuario
  return { ok: true };
}

/* INICIO DE SESIÓN: busca un usuario con ese correo y esa huella (SELECT).
   Si existe, recuerda quién es en localStorage ("heroforge_user"). */
async function iniciarSesion(email, password) {
  const hash = await hashPassword(password);
  const u = consultar('SELECT id, nombre FROM usuarios WHERE email = ? AND password_hash = ?', [email, hash]);
  if (!u.length) return { ok: false };
  localStorage.setItem('heroforge_user', JSON.stringify(u[0]));
  return { ok: true, usuario: u[0] };
}

/* Cerrar sesión = olvidar al usuario recordado */
function cerrarSesion() { localStorage.removeItem('heroforge_user'); }

/* Devuelve {id, nombre} del usuario con sesión iniciada, o null si no hay */
function usuarioActual() {
  try { return JSON.parse(localStorage.getItem('heroforge_user')); } catch { return null; }
}
