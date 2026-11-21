
<?php

require_once __DIR__ . "/includes/auth.php";
require_once __DIR__ . "/config/conexion.php";

$busqueda = trim($_GET["buscar"] ?? "");
$orden = $_GET["orden"] ?? "id";
$categoria = $_GET["categoria"] ?? "";
$favoritos = $_GET["favoritos"] ?? "";

$ordenesPermitidos = [
    "nombre" => "contactos.nombre ASC",
    "ciudad" => "contactos.ciudad ASC",
    "id" => "contactos.id DESC"
];

$ordenSQL = $ordenesPermitidos[$orden] ?? "contactos.id DESC";

$sql = "SELECT contactos.*, categorias.nombre AS nombre_categoria
        FROM contactos
        LEFT JOIN categorias ON contactos.id_categoria = categorias.id
        WHERE contactos.id_usuario = :id_usuario";

$parametros = [
    ":id_usuario" => $_SESSION["usuario_id"]
];

if ($busqueda !== "") {
    $sql .= " AND (
        contactos.nombre LIKE :buscar
        OR contactos.correo LIKE :buscar
        OR contactos.ciudad LIKE :buscar
    )";

    $parametros[":buscar"] = "%" . $busqueda . "%";
}

if ($categoria !== "") {
    $sql .= " AND contactos.id_categoria = :categoria";
    $parametros[":categoria"] = $categoria;
}

if ($favoritos === "1") {
    $sql .= " AND contactos.favorito = 1";
}

$sql .= " ORDER BY " . $ordenSQL;

$consulta = $conexion->prepare($sql);
$consulta->execute($parametros);
$contactos = $consulta->fetchAll(PDO::FETCH_ASSOC);

$consultaCategorias = $conexion->query(
    "SELECT * FROM categorias ORDER BY nombre ASC"
);

$categorias = $consultaCategorias->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis contactos</title>

    <link rel="stylesheet" href="css/estilos.css">

    <style>
        /* Alineacion del filtro de favoritos */
        .favorite-filter {
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: flex-start;
            gap: 9px;
            margin: 18px 0;
            padding: 0;
            min-height: 24px;
        }

        .favorite-filter input[type="checkbox"] {
            display: block;
            width: 18px;
            height: 18px;
            min-width: 18px;
            margin: 0;
            padding: 0;
            position: static;
            transform: none;
            flex: 0 0 18px;
            cursor: pointer;
            vertical-align: middle;
        }

        .favorite-filter label {
            display: block;
            margin: 0;
            padding: 0;
            line-height: 24px;
            font-weight: 600;
            cursor: pointer;
        }
    </style>

</head>

<body>

<div class="container">

    <div class="card">

        <h1>Mis contactos</h1>

        <p class="subtitle">
            Aquí puedes consultar y administrar tus contactos registrados.
        </p>

        <div class="actions">

            <a href="agregar_contacto.php" class="btn">
                Agregar nuevo contacto
            </a>

            <a href="dashboard.php" class="btn btn-secondary">
                Volver al panel
            </a>

        </div>

    </div>

    <div class="card">

        <h2>Buscar y filtrar contactos</h2>

        <form method="GET" action="listar_contactos.php">

            <label for="buscar">
                Buscar por nombre, correo o ciudad:
            </label>

            <input
                type="text"
                id="buscar"
                name="buscar"
                value="<?php echo htmlspecialchars($busqueda); ?>"
                placeholder="Escribe para buscar..."
            >

            <label for="orden">Ordenar por:</label>

            <select name="orden" id="orden">
                <option value="id" <?php echo $orden === "id" ? "selected" : ""; ?>>
                    Más recientes
                </option>

                <option value="nombre" <?php echo $orden === "nombre" ? "selected" : ""; ?>>
                    Nombre
                </option>

                <option value="ciudad" <?php echo $orden === "ciudad" ? "selected" : ""; ?>>
                    Ciudad
                </option>
            </select>

            <label for="categoria">Categoría:</label>

            <select name="categoria" id="categoria">

                <option value="">Todas las categorías</option>

                <?php foreach ($categorias as $cat): ?>

                    <option
                        value="<?php echo $cat["id"]; ?>"
                        <?php echo (string)$categoria === (string)$cat["id"] ? "selected" : ""; ?>
                    >
                        <?php echo htmlspecialchars($cat["nombre"]); ?>
                    </option>

                <?php endforeach; ?>

            </select>

            <div class="favorite-filter">

                <input
                    type="checkbox"
                    id="favoritos"
                    name="favoritos"
                    value="1"
                    <?php echo $favoritos === "1" ? "checked" : ""; ?>
                >

                <label for="favoritos">
                    ★ Mostrar solo favoritos
                </label>

            </div>

            <br>

            <button type="submit" class="btn">
                Aplicar filtros
            </button>

            <a href="listar_contactos.php" class="btn btn-secondary">
                Limpiar filtros
            </a>

        </form>

    </div>

    <?php if (count($contactos) > 0): ?>

        <div class="table-wrap">

            <table>

                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Teléfono</th>
                        <th>Correo</th>
                        <th>Ciudad</th>
                        <th>Categoría</th>
                        <th>Favorito</th>
                        <th>Acciones</th>
                    </tr>
                </thead>

                <tbody>

                    <?php foreach ($contactos as $contacto): ?>

                        <tr>

                            <td>
                                <?php echo htmlspecialchars($contacto["nombre"]); ?>
                            </td>

                            <td>
                                <?php echo htmlspecialchars($contacto["telefono"]); ?>
                            </td>

                            <td>
                                <?php echo htmlspecialchars($contacto["correo"]); ?>
                            </td>

                            <td>
                                <?php echo htmlspecialchars($contacto["ciudad"]); ?>
                            </td>

                            <td>
                                <?php echo htmlspecialchars($contacto["nombre_categoria"] ?? "Sin categoría"); ?>
                            </td>

                            <td>
                                <?php echo $contacto["favorito"] ? "★ Sí" : "No"; ?>
                            </td>

                            <td>

                                <a
                                    href="editar_contacto.php?id=<?php echo $contacto["id"]; ?>"
                                    class="btn btn-small"
                                >
                                    Editar
                                </a>

                                <form
                                    action="eliminar_contacto.php"
                                    method="POST"
                                    class="inline-form"
                                    onsubmit="return confirm('¿Seguro que deseas eliminar este contacto?');"
                                >

                                    <input
                                        type="hidden"
                                        name="id"
                                        value="<?php echo $contacto["id"]; ?>"
                                    >

                                    <input
                                        type="hidden"
                                        name="csrf_token"
                                        value="<?php echo htmlspecialchars($_SESSION["csrf_token"]); ?>"
                                    >

                                    <button type="submit" class="btn-danger btn-small">
                                        Eliminar
                                    </button>

                                </form>

                            </td>

                        </tr>

                    <?php endforeach; ?>

                </tbody>

            </table>

        </div>

    <?php else: ?>

        <div class="empty-message">
            No se encontraron contactos con los criterios seleccionados.
        </div>

    <?php endif; ?>

</div>

</body>
</html>
