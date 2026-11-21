
<?php

if ($_SERVER['HTTP_HOST'] === 'localhost') {

    // Conexion local XAMPP
    $host = "localhost";
    $dbname = "agenda_contactos";
    $usuario = "root";
    $password = "";

} else {

    // Conexion hosting InfinityFree
    $host = "sql101.infinityfree.com";
    $dbname = "if0_43501239_agenda";
    $usuario = "if0_43501239";
    $password = "TU_CONTRASENA_DE_INFINITYFREE";

}

try {
    $conexion = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
        $usuario,
        $password
    );

    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    die("Error al conectar con la base de datos.");
}

?>
