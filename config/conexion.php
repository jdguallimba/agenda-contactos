
<?php

$host = "localhost";
$dbname = "agenda_contactos";
$usuario = "root";
$password = "";

try {
    $conexion = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
        $usuario,
        $password
    );

    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    die("Error al conectar con la base de datos: " . $e->getMessage());
}

?>
