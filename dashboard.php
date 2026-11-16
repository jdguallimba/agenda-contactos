
<?php

require_once __DIR__ . "/includes/auth.php";

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
                ¡Bienvenido, <?php echo htmlspecialchars($_SESSION["usuario_nombre"]); ?>!
            </h1>

            <p>
                Administra tu información y mantén tus contactos organizados en un solo lugar.
            </p>

        </div>

        <div class="card">

            <h2>Panel principal</h2>

            <p class="subtitle">
                Selecciona una de las siguientes opciones para continuar.
            </p>

            <div class="actions">

                <a href="agregar_contacto.php" class="btn">
                    Agregar contacto
                </a>

                <a href="listar_contactos.php" class="btn">
                    Ver mis contactos
                </a>

                <a href="logout.php" class="btn btn-secondary">
                    Cerrar sesión
                </a>

            </div>

        </div>

    </div>

</body>
</html>
