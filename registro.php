
<?php

require_once __DIR__ . "/config/conexion.php";

$mensaje = "";
$tipo_mensaje = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $nombre = trim($_POST["nombre"] ?? "");
    $correo = trim($_POST["correo"] ?? "");
    $password = $_POST["password"] ?? "";
    $confirmar_password = $_POST["confirmar_password"] ?? "";

    if ($nombre === "" || $correo === "" || $password === "" || $confirmar_password === "") {

        $mensaje = "Todos los campos son obligatorios.";
        $tipo_mensaje = "error";

    } elseif (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {

        $mensaje = "Ingresa un correo electrónico válido.";
        $tipo_mensaje = "error";

    } elseif (strlen($password) < 8) {

        $mensaje = "La contraseña debe tener al menos 8 caracteres.";
        $tipo_mensaje = "error";

    } elseif ($password !== $confirmar_password) {

        $mensaje = "Las contraseñas no coinciden.";
        $tipo_mensaje = "error";

    } else {

        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        try {

            $sql = "INSERT INTO usuarios (nombre, correo, password)
                    VALUES (:nombre, :correo, :password)";

            $consulta = $conexion->prepare($sql);

            $consulta->execute([
                ":nombre" => $nombre,
                ":correo" => $correo,
                ":password" => $password_hash
            ]);

            $mensaje = "Cuenta creada correctamente. Ya puedes iniciar sesión.";
            $tipo_mensaje = "success";

        } catch (PDOException $e) {

            if ($e->getCode() === "23000") {
                $mensaje = "Este correo electrónico ya está registrado.";
            } else {
                $mensaje = "Ocurrió un error al registrar el usuario.";
            }

            $tipo_mensaje = "error";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear cuenta</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>

<body>

    <div class="container-small">

        <div class="card">

            <h1>Crear una cuenta</h1>

            <p class="subtitle">
                Regístrate para comenzar a administrar tus contactos.
            </p>

            <?php if ($mensaje !== ""): ?>
                <div class="alert <?php echo $tipo_mensaje === "error" ? "alert-error" : "alert-success"; ?>">
                    <?php echo htmlspecialchars($mensaje); ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="">

                <label>Nombre completo:</label>
                <input type="text" name="nombre" required>

                <label>Correo electrónico:</label>
                <input type="email" name="correo" required>

                <label>Contraseña:</label>
                <input type="password" name="password" required minlength="8">

                <label>Confirmar contraseña:</label>
                <input type="password" name="confirmar_password" required minlength="8">

                <button type="submit">Registrarme</button>

            </form>

            <p>
                ¿Ya tienes una cuenta?
                <a href="login.php">Inicia sesión</a>
            </p>

        </div>

    </div>

</body>
</html>
