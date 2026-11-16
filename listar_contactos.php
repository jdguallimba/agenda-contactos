
<?php

require_once __DIR__ . "/includes/auth.php";
require_once __DIR__ . "/config/conexion.php";

$sql = "SELECT * FROM contactos
        WHERE id_usuario = :id_usuario
        ORDER BY id DESC";

$consulta = $conexion->prepare($sql);

$consulta->execute([
    ":id_usuario" => $_SESSION["usuario_id"]
]);

$contactos = $consulta->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis contactos</title>
    <link rel="stylesheet" href="css/estilos.css">
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

        <?php if (count($contactos) > 0): ?>

            <div class="table-wrap">

                <table>

                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Teléfono</th>
                            <th>Correo</th>
                            <th>Ciudad</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php foreach ($contactos as $contacto): ?>

                            <tr>

                                <td><?php echo htmlspecialchars($contacto["nombre"]); ?></td>

                                <td><?php echo htmlspecialchars($contacto["telefono"]); ?></td>

                                <td><?php echo htmlspecialchars($contacto["correo"]); ?></td>

                                <td><?php echo htmlspecialchars($contacto["ciudad"]); ?></td>

                                <td>

                                    <a href="editar_contacto.php?id=<?php echo $contacto["id"]; ?>"
                                       class="btn btn-small">
                                        Editar
                                    </a>

                                    <form action="eliminar_contacto.php"
                                          method="POST"
                                          class="inline-form"
                                          onsubmit="return confirm('¿Seguro que deseas eliminar este contacto?');">

                                        <input type="hidden" name="id"
                                               value="<?php echo $contacto["id"]; ?>">

                                        <input type="hidden" name="csrf_token"
                                               value="<?php echo htmlspecialchars($_SESSION["csrf_token"]); ?>">

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
                No tienes contactos registrados. Puedes agregar uno utilizando el botón de arriba.
            </div>

        <?php endif; ?>

    </div>

</body>
</html>
