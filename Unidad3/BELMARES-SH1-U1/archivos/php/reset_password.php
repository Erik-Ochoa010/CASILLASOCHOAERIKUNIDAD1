<?php
session_start();
require_once '../db/db.php';

$token = $_GET['token'] ?? '';
$error = '';
$success = '';

if (!$token) {
    die('Token inválido.');
}

// Buscar token válido y no expirado
$query = $cnnPDO->prepare("SELECT id FROM usuarios WHERE reset_token = :token AND reset_expires > NOW()");
$query->bindParam(':token', $token);
$query->execute();
$user = $query->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    die('Token inválido o expirado.');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = $_POST['password'] ?? '';
    $password_confirm = $_POST['password_confirm'] ?? '';

    if (empty($password) || empty($password_confirm)) {
        $error = "Por favor, completa ambos campos.";
    } elseif ($password !== $password_confirm) {
        $error = "Las contraseñas no coinciden.";
    } else {
        // Hashear y actualizar contraseña
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $update = $cnnPDO->prepare("UPDATE usuarios SET password = :password, reset_token = NULL, reset_expires = NULL WHERE id = :id");
        $update->bindParam(':password', $hashed);
        $update->bindParam(':id', $user['id']);
        $update->execute();

        $success = "Contraseña actualizada correctamente. Puedes <a href='iniciar.php'>iniciar sesión</a>.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Cambiar contraseña</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(to bottom right, #00c6ff, #0072ff);
            color: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background: rgba(255, 255, 255, 0.08);
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 0 25px rgba(0,0,0,0.4);
            max-width: 400px;
            width: 100%;
        }

        h1 {
            text-align: center;
            margin-bottom: 25px;
        }

        form label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
        }

        input[type="password"],
        input[type="submit"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: none;
            border-radius: 8px;
        }

        input[type="password"] {
            background-color: #fff;
            color: #333;
        }

        input[type="submit"] {
            background-color: #00ffcc;
            color: #000;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #00ccaa;
        }

        .message {
            text-align: center;
            margin-bottom: 20px;
        }

        .error {
            color: #ffb3b3;
            font-weight: bold;
        }

        .success {
            color: #b3ffcc;
            font-weight: bold;
        }

        a {
            color: #ffffff;
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Cambiar contraseña</h1>

        <?php if ($error): ?>
            <div class="message error"><?= htmlspecialchars($error) ?></div>
        <?php elseif ($success): ?>
            <div class="message success"><?= $success ?></div>
        <?php endif; ?>

        <?php if (!$success): ?>
        <form method="POST" action="">
            <label for="password">Nueva contraseña:</label>
            <input type="password" name="password" id="password" required />

            <label for="password_confirm">Confirmar contraseña:</label>
            <input type="password" name="password_confirm" id="password_confirm" required />

            <input type="submit" value="Cambiar contraseña" />
        </form>
        <?php endif; ?>
    </div>
</body>
</html>
