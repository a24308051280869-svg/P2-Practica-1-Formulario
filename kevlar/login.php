<?php
// INICIAR SESIÓN: revisa en la base de datos que el correo y la contraseña sean correctos

include "conexion.php";
include "funciones.php";

$error = "";
$correo = "";

// Esto solo se ejecuta cuando le dieron clic al botón "Entrar"
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $correo = trim($_POST['correo']);
    $contrasena = $_POST['contrasena'];

    // Busco en la tabla usuarios a alguien con ese correo
    $consulta = mysqli_prepare($conexion, "SELECT id, nombre, contrasena FROM usuarios WHERE correo = ?");
    mysqli_stmt_bind_param($consulta, "s", $correo);
    mysqli_stmt_execute($consulta);
    $resultado = mysqli_stmt_get_result($consulta);
    $usuario = mysqli_fetch_assoc($resultado);   // si no existe, $usuario queda vacío

    // Si existe y la contraseña coincide con la cifrada, lo dejo entrar
    if ($usuario && password_verify($contrasena, $usuario['contrasena'])) {
        $_SESSION['id'] = $usuario['id'];
        $_SESSION['nombre'] = $usuario['nombre'];
        header("Location: index.php");
        exit;
    } else {
        $error = "Correo o contraseña incorrectos.";
    }
}

$titulo = "Iniciar sesión";
$pagina = "login";
include "encabezado.php";
?>

<section class="formulario-fondo">
    <div class="formulario">
        <h1>Iniciar <span class="rojo-texto">sesión</span></h1>
        <p class="gris">Escribe tu correo y tu contraseña.</p>

        <!-- Aviso verde cuando viene de registrarse -->
        <?php if (isset($_GET['registro'])) { ?>
            <div class="aviso bien">¡Cuenta creada! Ya puedes iniciar sesión.</div>
        <?php } ?>

        <!-- Aviso rojo si se equivocó -->
        <?php if ($error != "") { ?>
            <div class="aviso error"><?php echo $error; ?></div>
        <?php } ?>

        <form method="post" action="login.php">
            <label>Correo electrónico
                <input type="email" name="correo" value="<?php echo htmlspecialchars($correo); ?>" required>
            </label>
            <label>Contraseña
                <input type="password" name="contrasena" required>
            </label>
            <button class="boton rojo grande completo" type="submit">Entrar</button>
        </form>

        <p class="alternativa">¿Aún no tienes cuenta? <a href="registrar.php">Regístrate</a></p>
    </div>
</section>

<?php footer(); ?>
</body>
</html>
