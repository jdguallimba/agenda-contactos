<?php

session_start();

// Vaciar las variables de sesion
$_SESSION = [];

// Eliminar la cookie de sesion
if (ini_get("session.use_cookies")) {
    $parametros = session_get_cookie_params();

    setcookie(
        session_name(),
        "",
        time() - 42000,
        $parametros["path"],
        $parametros["domain"],
        $parametros["secure"],
        $parametros["httponly"]
    );
}

// Destruir la sesion
session_destroy();

// Regresar al inicio de sesion
header("Location: login.php");
exit;

?>