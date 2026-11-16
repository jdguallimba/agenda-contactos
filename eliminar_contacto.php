
<?php

require_once __DIR__ . "/includes/auth.php";
require_once __DIR__ . "/config/conexion.php";

// Verificar que la solicitud sea POST
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: listar_contactos.php");
    exit;
}

// Verificar el token de seguridad
if (!hash_equals($_SESSION["csrf_token"], $_POST["csrf_token"] ?? "")) {
    http_response_code(403);
    exit("Solicitud no válida. Intenta nuevamente.");
}

$id = $_POST["id"] ?? null;

if (!$id || !filter_var($id, FILTER_VALIDATE_INT)) {
    header("Location: listar_contactos.php");
    exit;
}

// Eliminar únicamente contactos del usuario que inició sesión
$sql = "DELETE FROM contactos
        WHERE id = :id AND id_usuario = :id_usuario";

$consulta = $conexion->prepare($sql);

$consulta->execute([
    ":id" => $id,
    ":id_usuario" => $_SESSION["usuario_id"]
]);

header("Location: listar_contactos.php");
exit;

?>
