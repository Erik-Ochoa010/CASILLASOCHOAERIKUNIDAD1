<?php
session_start();
require_once '../db/db.php';

$message = '';
$token = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $correo = $_POST['correo'] ?? '';

    // Verificar si el correo existe en la tabla 'usuarios'
    $query = $cnnPDO->prepare("SELECT id, nombre FROM usuarios WHERE correo = :correo");
    $query->bindParam(':correo', $correo);
    $query->execute();
    $user = $query->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // Crear token único y expiración (1 hora)
        $token = bin2hex(random_bytes(16));
        $expires = date('Y-m-d H:i:s', time() + 3600);

        // Guardar token y expiración
        $update = $cnnPDO->prepare("UPDATE usuarios SET reset_token = :token, reset_expires = :expires WHERE id = :id");
        $update->bindParam(':token', $token);
        $update->bindParam(':expires', $expires);
        $update->bindParam(':id', $user['id']);
        $update->execute();

        // Enlace de recuperación (simulado)
        $resetLink = "reset_password.php?token=$token";

        // Cambiar mensaje
        $message = "<a class='recovery-link' href='$resetLink'>Correo localizado, haz clic para cambiar la contraseña</a>";
    } else {
        $message = "<span class='error'>No existe ninguna cuenta asociada a ese correo.</span>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Recuperar contraseña</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(to bottom right, #4a90e2, #9013fe);
            color: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background: rgba(255, 255, 255, 0.1);
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0,0,0,0.3);
            width: 100%;
            max-width: 400px;
        }

        h1 {
            text-align: center;
            margin-bottom: 30px;
        }

        form label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
        }

        input[type="email"],
        input[type="submit"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: none;
            border-radius: 8px;
        }

        input[type="email"] {
            background-color: #fff;
            color: #333;
        }

        input[type="submit"] {
            background-color: #00c6ff;
            color: #fff;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #007ac6;
        }

        .message {
            text-align: center;
            margin-bottom: 20px;
        }

        .recovery-link {
            color: #00ffcc;
            background-color: rgba(0,0,0,0.3);
            padding: 10px 15px;
            display: inline-block;
            border-radius: 10px;
            text-decoration: none;
            font-weight: bold;
        }

        .error {
            color: #ffcccc;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Recuperar contraseña</h1>
        <?php if ($message): ?>
            <div class="message"><?= $message ?></div>
        <?php endif; ?>
        <form method="POST" action="">
            <label for="correo">Correo electrónico:</label>
            <input type="email" name="correo" id="correo" required />
            <input type="submit" value="Enviar enlace de recuperación" />
        </form>
    </div>
</body>
</html>
