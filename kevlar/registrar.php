<?php
// REGISTRAR: formulario para crear una cuenta nueva.
// Los datos se guardan en la tabla "usuarios" de la base de datos.

include "conexion.php";
include "funciones.php";

// Variables vacías para que el formulario no marque error la primera vez
$nombre = "";
$apellido = "";
$correo = "";
$telefono = "";
$errores = array();   // aquí voy guardando los errores que encuentre

// Esto solo se ejecuta cuando le dieron clic al botón "Registrarme"
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Saco lo que escribió la persona en el formulario
    $nombre = trim($_POST['nombre']);
    $apellido = trim($_POST['apellido']);
    $correo = trim($_POST['correo']);
    $telefono = trim($_POST['telefono']);
    $contrasena = $_POST['contrasena'];
    $contrasena2 = $_POST['contrasena2'];

    // ----- Reviso que todo esté bien -----
    if ($nombre == "" || $apellido == "") {
        $errores[] = "Nombre y apellido son obligatorios.";
    }
    if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        $errores[] = "Escribe un correo válido.";
    }
    if ($telefono != "" && !preg_match('/^[0-9 +()-]{7,20}$/', $telefono)) {
        $errores[] = "El teléfono no es válido.";
    }
    if (strlen($contrasena) < 8) {
        $errores[] = "La contraseña debe tener mínimo 8 caracteres.";
    }
    if ($contrasena != $contrasena2) {
        $errores[] = "Las contraseñas no coinciden.";
    }

    // ----- Si todo está bien, reviso que el correo no esté repetido -----
    if (count($errores) == 0) {
        $consulta = mysqli_prepare($conexion, "SELECT id FROM usuarios WHERE correo = ?");
        mysqli_stmt_bind_param($consulta, "s", $correo);
        mysqli_stmt_execute($consulta);
        $resultado = mysqli_stmt_get_result($consulta);

        if (mysqli_num_rows($resultado) > 0) {
            $errores[] = "Ese correo ya está registrado.";
        }
    }

    // ----- Si sigue sin errores, guardo al usuario en la base de datos -----
    if (count($errores) == 0) {
        // La contraseña se cifra, así no se guarda tal cual la escribió
        $cifrada = password_hash($contrasena, PASSWORD_DEFAULT);

        $consulta = mysqli_prepare($conexion, "INSERT INTO usuarios (nombre, apellido, correo, telefono, contrasena) VALUES (?, ?, ?, ?, ?)");
        mysqli_stmt_bind_param($consulta, "sssss", $nombre, $apellido, $correo, $telefono, $cifrada);
        mysqli_stmt_execute($consulta);

        // Lo mando a iniciar sesión
        header("Location: login.php?registro=ok");
        exit;
    }
}

$titulo = "Registrar";
$pagina = "registrar";
include "encabezado.php";
?>

<section class="formulario-fondo">
    <div class="formulario">
        <h1>Crear <span class="rojo-texto">cuenta</span></h1>
        <p class="gris">Tus datos se guardan en nuestra base de datos.</p>

        <!-- Si hubo errores, los muestro en rojo -->
        <?php foreach ($errores as $error) { ?>
            <div class="aviso error"><?php echo $error; ?></div>
        <?php } ?>

        <!-- method="post" manda los datos a esta misma página -->
        <form method="post" action="registrar.php">
            <label>Nombre
                <input type="text" name="nombre" value="<?php echo htmlspecialchars($nombre); ?>" required>
            </label>
            <label>Apellido
                <input type="text" name="apellido" value="<?php echo htmlspecialchars($apellido); ?>" required>
            </label>
            <label>Correo electrónico
                <input type="email" name="correo" value="<?php echo htmlspecialchars($correo); ?>" required>
            </label>
            <label>Teléfono (opcional)
                <input type="text" name="telefono" value="<?php echo htmlspecialchars($telefono); ?>">
            </label>
            <label>Contraseña
                <input type="password" name="contrasena" required>
            </label>
            <label>Confirmar contraseña
                <input type="password" name="contrasena2" required>
            </label>
            <button class="boton rojo grande completo" type="submit">Registrarme</button>
        </form>

        <p class="alternativa">¿Ya tienes cuenta? <a href="login.php">Inicia sesión</a></p>
    </div>
</section>

<?php footer(); ?>
</body>
</html>
