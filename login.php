
<?php

session_start();

require_once __DIR__ . "/config/conexion.php";

if (isset($_SESSION["usuario_id"])) {
    header("Location: dashboard.php");
    exit;
}

$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $correo = trim($_POST["correo"] ?? "");
    $password = $_POST["password"] ?? "";

    if ($correo === "" || $password === "") {

        $mensaje = "Completa todos los campos.";

    } else {

        $sql = "SELECT * FROM usuarios WHERE correo = :correo";

        $consulta = $conexion->prepare($sql);
        $consulta->execute([":correo" => $correo]);

        $usuario = $consulta->fetch(PDO::FETCH_ASSOC);

        if ($usuario && password_verify($password, $usuario["password"])) {

            session_regenerate_id(true);

            $_SESSION["usuario_id"] = $usuario["id"];
            $_SESSION["usuario_nombre"] = $usuario["nombre"];

            header("Location: dashboard.php");
            exit;

        } else {

            $mensaje = "Correo o contraseña incorrectos.";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>

<body>

    <div class="container-small">

        <div class="card">

            <h1>Agenda de Contactos</h1>

            <p class="subtitle">
                Inicia sesión para administrar tus contactos personales.
            </p>

            <?php if ($mensaje !== ""): ?>
                <div class="alert alert-error">
                    <?php echo htmlspecialchars($mensaje); ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="">

                <label>Correo electrónico:</label>
                <input type="email" name="correo" required>

                <label>Contraseña:</label>
                <input type="password" name="password" required>

                <button type="submit">Ingresar</button>

            </form>

            <p>
                ¿Todavía no tienes una cuenta?
                <a href="registro.php">Regístrate aquí</a>
            </p>

        </div>

    </div>

</body>
</html>
