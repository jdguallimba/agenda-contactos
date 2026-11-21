
<?php

require_once __DIR__ . "/includes/auth.php";
require_once __DIR__ . "/config/conexion.php";

$mensaje = "";
$tipo_mensaje = "";

$consultaCategorias = $conexion->query("SELECT * FROM categorias ORDER BY nombre ASC");
$categorias = $consultaCategorias->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if (!hash_equals($_SESSION["csrf_token"], $_POST["csrf_token"] ?? "")) {
        http_response_code(403);
        exit("Solicitud no válida. Intenta nuevamente.");
    }

    $nombre = trim($_POST["nombre"] ?? "");
    $telefono = trim($_POST["telefono"] ?? "");
    $correo = trim($_POST["correo"] ?? "");
    $ciudad = trim($_POST["ciudad"] ?? "");
    $id_categoria = $_POST["id_categoria"] ?? "";

    if ($nombre === "" || $telefono === "" || $correo === "" || $ciudad === "" || $id_categoria === "") {

        $mensaje = "Todos los campos son obligatorios.";
        $tipo_mensaje = "error";

    } elseif (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {

        $mensaje = "Ingresa un correo electrónico válido.";
        $tipo_mensaje = "error";

    } else {

        $verificar = $conexion->prepare("SELECT id FROM categorias WHERE id = :id");
        $verificar->execute([":id" => $id_categoria]);

        if (!$verificar->fetch()) {

            $mensaje = "Selecciona una categoría válida.";
            $tipo_mensaje = "error";

        } else {

            $sql = "INSERT INTO contactos
                    (id_usuario, nombre, telefono, correo, ciudad, id_categoria)
                    VALUES
                    (:id_usuario, :nombre, :telefono, :correo, :ciudad, :id_categoria)";

            $consulta = $conexion->prepare($sql);

            $consulta->execute([
                ":id_usuario" => $_SESSION["usuario_id"],
                ":nombre" => $nombre,
                ":telefono" => $telefono,
                ":correo" => $correo,
                ":ciudad" => $ciudad,
                ":id_categoria" => $id_categoria
            ]);

            $mensaje = "Contacto agregado correctamente.";
            $tipo_mensaje = "success";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar contacto</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>

<body>

    <div class="container-small">

        <div class="card">

            <h1>Agregar contacto</h1>

            <p class="subtitle">
                Registra una nueva persona en tu agenda.
            </p>

            <?php if ($mensaje !== ""): ?>
                <div class="alert <?php echo $tipo_mensaje === "error" ? "alert-error" : "alert-success"; ?>">
                    <?php echo htmlspecialchars($mensaje); ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="">

                <input type="hidden" name="csrf_token"
                       value="<?php echo htmlspecialchars($_SESSION["csrf_token"]); ?>">

                <label>Nombre:</label>
                <input type="text" name="nombre" required>

                <label>Teléfono:</label>
                <input type="text" name="telefono" required>

                <label>Correo electrónico:</label>
                <input type="email" name="correo" required>

                <label>Ciudad:</label>
                <input type="text" name="ciudad" required>

                <label>Categoría:</label>
                <select name="id_categoria" required>
                    <option value="">Selecciona una categoría</option>

                    <?php foreach ($categorias as $categoria): ?>
                        <option value="<?php echo $categoria["id"]; ?>">
                            <?php echo htmlspecialchars($categoria["nombre"]); ?>
                        </option>
                    <?php endforeach; ?>

                </select>

                <button type="submit">Guardar contacto</button>

            </form>

            <div class="footer-links">
                <a href="listar_contactos.php">Mis contactos</a>
                <a href="dashboard.php">Panel principal</a>
            </div>

        </div>

    </div>

</body>
</html>
