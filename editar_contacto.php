
<?php

require_once __DIR__ . "/includes/auth.php";
require_once __DIR__ . "/config/conexion.php";

$id = $_GET["id"] ?? null;

if (!$id || !filter_var($id, FILTER_VALIDATE_INT)) {
    header("Location: listar_contactos.php");
    exit;
}

// Consultar el contacto y comprobar que pertenezca al usuario
$sql = "SELECT * FROM contactos
        WHERE id = :id AND id_usuario = :id_usuario";

$consulta = $conexion->prepare($sql);

$consulta->execute([
    ":id" => $id,
    ":id_usuario" => $_SESSION["usuario_id"]
]);

$contacto = $consulta->fetch(PDO::FETCH_ASSOC);

if (!$contacto) {
    header("Location: listar_contactos.php");
    exit;
}

$mensaje = "";
$tipo_mensaje = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if (!hash_equals($_SESSION["csrf_token"], $_POST["csrf_token"] ?? "")) {
        http_response_code(403);
        exit("Solicitud no válida. Intenta nuevamente.");
    }

    $nombre = trim($_POST["nombre"] ?? "");
    $telefono = trim($_POST["telefono"] ?? "");
    $correo = trim($_POST["correo"] ?? "");
    $ciudad = trim($_POST["ciudad"] ?? "");

    if ($nombre === "" || $telefono === "" || $correo === "" || $ciudad === "") {

        $mensaje = "Todos los campos son obligatorios.";
        $tipo_mensaje = "error";

    } elseif (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {

        $mensaje = "Ingresa un correo electrónico válido.";
        $tipo_mensaje = "error";

    } else {

        $sql = "UPDATE contactos
                SET nombre = :nombre,
                    telefono = :telefono,
                    correo = :correo,
                    ciudad = :ciudad
                WHERE id = :id AND id_usuario = :id_usuario";

        $consulta = $conexion->prepare($sql);

        $consulta->execute([
            ":nombre" => $nombre,
            ":telefono" => $telefono,
            ":correo" => $correo,
            ":ciudad" => $ciudad,
            ":id" => $id,
            ":id_usuario" => $_SESSION["usuario_id"]
        ]);

        header("Location: listar_contactos.php");
        exit;
    }

    // Actualizar los datos mostrados en el formulario
    $contacto["nombre"] = $nombre;
    $contacto["telefono"] = $telefono;
    $contacto["correo"] = $correo;
    $contacto["ciudad"] = $ciudad;
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar contacto</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>

<body>

    <div class="container-small">

        <div class="card">

            <h1>Editar contacto</h1>

            <p class="subtitle">
                Modifica la información de tu contacto.
            </p>

            <?php if ($mensaje !== ""): ?>
                <div class="alert alert-error">
                    <?php echo htmlspecialchars($mensaje); ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="">

                <input type="hidden" name="csrf_token"
                       value="<?php echo htmlspecialchars($_SESSION["csrf_token"]); ?>">

                <label>Nombre:</label>
                <input type="text" name="nombre"
                       value="<?php echo htmlspecialchars($contacto["nombre"]); ?>" required>

                <label>Teléfono:</label>
                <input type="text" name="telefono"
                       value="<?php echo htmlspecialchars($contacto["telefono"]); ?>" required>

                <label>Correo electrónico:</label>
                <input type="email" name="correo"
                       value="<?php echo htmlspecialchars($contacto["correo"]); ?>" required>

                <label>Ciudad:</label>
                <input type="text" name="ciudad"
                       value="<?php echo htmlspecialchars($contacto["ciudad"]); ?>" required>

                <button type="submit">Guardar cambios</button>

            </form>

            <div class="footer-links">
                <a href="listar_contactos.php">Volver a mis contactos</a>
                <a href="dashboard.php">Panel principal</a>
            </div>

        </div>

    </div>

</body>
</html>
