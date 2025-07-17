<?php
session_start();

function protegerRuta($rolesPermitidos = []) {
    if (!isset($_SESSION['sesion'])) {
        header("Location: ../../index.html");
        exit();
    }

    // Si se definen roles para esa ruta, verificar
    if (!empty($rolesPermitidos)) {
        if (!isset($_SESSION['sesion']['rol']) || !in_array($_SESSION['sesion']['rol'], $rolesPermitidos)) {
            // No autorizado
            header("HTTP/1.1 403 Forbidden");
            echo "No tienes permiso para acceder a esta página.";
            exit();
        }
    }
}
