<?php
require_once '../db/db.php';
session_start();

if (isset($_POST['registrarme'])) {
    // Recibir y sanitizar datos
    $correo = filter_var($_POST['correo'], FILTER_SANITIZE_EMAIL);
    $nombre = filter_var($_POST['nombre'], FILTER_SANITIZE_STRING);
    $celular = filter_var($_POST['celular'], FILTER_SANITIZE_STRING);
    $ingreso = filter_var($_POST['ingreso'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $password = $_POST['password'];

    // Hashear contraseña
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Tipo usuario por defecto
    $tipoUsuario = 'clientes';

    try {
        $insertQuery = $cnnPDO->prepare("INSERT INTO usuarios (correo, nombre, celular, ingreso, password, tipo_usuario) VALUES (:correo, :nombre, :celular, :ingreso, :password, :tipo_usuario)");
        $insertQuery->bindParam(':correo', $correo);
        $insertQuery->bindParam(':nombre', $nombre);
        $insertQuery->bindParam(':celular', $celular);
        $insertQuery->bindParam(':ingreso', $ingreso);
        $insertQuery->bindParam(':password', $hashedPassword);
        $insertQuery->bindParam(':tipo_usuario', $tipoUsuario);

        $insertQuery->execute();

        // Redireccionar al login
        header("Location: iniciar.php");
        exit();

    } catch (PDOException $e) {
        echo "Error al registrar usuario: " . $e->getMessage();
    }
}
?>
