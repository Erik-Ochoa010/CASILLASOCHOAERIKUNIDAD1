<?php
require_once '../db/db.php';
session_start();

$error = '';

if (isset($_POST['acceder'])) {
    $correo = $_POST['correo'];
    $password = $_POST['password'];

    $query = $cnnPDO->prepare('SELECT * FROM usuarios WHERE correo = :correo');
    $query->bindParam(':correo', $correo);
    $query->execute();

    $user = $query->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        if (password_verify($password, $user['password'])) {
            session_regenerate_id(true);

            // Guardar toda la info del usuario en un arreglo dentro de $_SESSION['sesion']
            $_SESSION['sesion'] = [
                'id' => $user['id_usuario'],
                'correo' => $user['correo'],
                'nombre' => $user['nombre'],
                'rol' => $user['tipo_usuario'],
                'ip' => $_SERVER['REMOTE_ADDR'],
                'user_agent' => $_SERVER['HTTP_USER_AGENT']
            ];

            if ($user['tipo_usuario'] === 'admin') {
                header("Location: admin_dashboard.php");
            } else {
                header("Location: home.php");
            }
            exit();
        } else {
            $error = "Contraseña incorrecta.";
        }
    } else {
        $error = "Usuario no encontrado.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../css/iniciar.css" />
    <title>Iniciar Sesión</title>
    <link rel="shortcut icon" href="../img/icon.png" type="image/x-icon">
</head>
<body>
    <form action="" method="post" class="form">
        <center>
            <h1>Iniciar Sesión</h1>
            <img src="../img/index/logo.png" alt="Logo" width="200px" height="50px">
        </center>

        <?php if (!empty($error)): ?>
            <p style="color:red; text-align:center;"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <!-- Progress Bar -->
        <div class="progressbar">
            <div class="progress" id="progress"></div>
            <div class="progress-step progress-step-active" data-title="Email"></div>
            <div class="progress-step" data-title="Entrar"></div>
        </div>

        <!-- Step 1: Correo -->
        <div class="form-step form-step-active">
            <div class="input-group">
                <label for="correo"><b><i>Email:</i></b></label>
                <input type="email" name="correo" id="correo" autocomplete="off" required />
            </div>
            <div>
                <a href="#" class="btn btn-next width-50 ml-auto">Continuar 🢂</a>
            </div>
        </div>

        <!-- Step 2: Contraseña -->
        <div class="form-step">
            <div class="input-group">
                <label for="password"><b><i>Contraseña:</i></b></label>
                <input type="password" name="password" id="password" autocomplete="off" required />
            </div>
            <div class="btns-group">
                <a href="#" class="btn btn-prev">🢀 Volver</a>
                <input type="submit" name="acceder" value="Iniciar Sesión 🏠" class="btn" style="background-color: #43ba43;" />
            </div>
        </div>
    </form>

    <script>
      document.addEventListener('DOMContentLoaded', () => {
        const btnNext = document.querySelector('.btn-next');
        const btnPrev = document.querySelector('.btn-prev');
        const steps = document.querySelectorAll('.form-step');

        btnNext.addEventListener('click', (e) => {
          e.preventDefault();
          steps[0].classList.remove('form-step-active');
          steps[1].classList.add('form-step-active');
        });

        btnPrev.addEventListener('click', (e) => {
          e.preventDefault();
          steps[1].classList.remove('form-step-active');
          steps[0].classList.add('form-step-active');
        });
      });
    </script>
</body>
</html>
