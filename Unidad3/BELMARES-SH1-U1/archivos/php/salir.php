<?php
session_start();

// Limpiar todas las variables de sesión
$_SESSION = [];

// Destruir sesión completamente
session_destroy();

// Redirigir a la página principal o login
header("Location: ../../index.html");
exit();
?>
