
<?php

require_once __DIR__ . "/includes/auth.php";
require_once __DIR__ . "/config/conexion.php";

// Obtener los datos del usuario
$consultaUsuario = $conexion->prepare(
    "SELECT nombre, correo FROM usuarios WHERE id = ?"
);

$consultaUsuario->execute([$_SESSION["usuario_id"]]);
$usuario = $consultaUsuario->fetch(PDO::FETCH_ASSOC);

// Obtener los contactos del usuario
$consultaContactos = $conexion->prepare(
    "SELECT id, nombre, telefono, correo, ciudad
     FROM contactos
     WHERE id_usuario = ?
     ORDER BY id DESC"
);

$consultaContactos->execute([$_SESSION["usuario_id"]]);
$contactos = $consultaContactos->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel principal</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>

<body>

    <div class="container">

        <div class="welcome">

            <h1>
                ¡Bienvenido, <?php echo htmlspecialchars($usuario["nombre"]); ?>!
            </h1>

            <p>
                Administra tu información y mantén tus contactos organizados en un solo lugar.
            </p>

        </div>

        <div class="card">

            <h2>Panel principal</h2>

            <p>
                <strong>Nombre:</strong>
                <?php echo htmlspecialchars($usuario["nombre"]); ?>
            </p>

            <p>
                <strong>Correo electrónico:</strong>
                <?php echo htmlspecialchars($usuario["correo"]); ?>
            </p>

            <p class="subtitle">
                Aquí puedes consultar y administrar tus contactos personales.
            </p>

            <div class="actions">

                <a href="agregar_contacto.php" class="btn">
                    Agregar contacto
                </a>

                <a href="listar_contactos.php" class="btn">
                    Administrar contactos
                </a>

                <a href="logout.php" class="btn btn-secondary">
                    Cerrar sesión
                </a>

            </div>

        </div>

        <div class="card">

            <h2>Mis contactos</h2>

            <?php if (count($contactos) > 0): ?>

                <div class="table-wrap">

                    <table>

                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Teléfono</th>
                                <th>Correo</th>
                                <th>Ciudad</th>
                            </tr>
                        </thead>

                        <tbody>

                            <?php foreach ($contactos as $contacto): ?>

                                <tr>
                                    <td><?php echo htmlspecialchars($contacto["nombre"]); ?></td>
                                    <td><?php echo htmlspecialchars($contacto["telefono"]); ?></td>
                                    <td><?php echo htmlspecialchars($contacto["correo"]); ?></td>
                                    <td><?php echo htmlspecialchars($contacto["ciudad"]); ?></td>
                                </tr>

                            <?php endforeach; ?>

                        </tbody>

                    </table>

                </div>

            <?php else: ?>

                <p class="subtitle">
                    Todavía no tienes contactos registrados.
                </p>

            <?php endif; ?>

        </div>

    </div>

</body>
</html>
