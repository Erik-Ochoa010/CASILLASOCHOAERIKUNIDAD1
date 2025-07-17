<?php
//Si no se ha creado una sesion valida desde el login o se destruyo la sesion no permitimos la entrada a esta pagina
    session_start();
    $sesion = $_SESSION['sesion'];
    if ($sesion['correo'] == null && $sesion['password'] == null) {
        header("Location: ../../index.html");
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi perfil</title>
    <!-- Icon of the page -->
    <link rel="shortcut icon" href="../img/icon.png" type="image/x-icon">
    <!-- Css Perfil -->
    <link rel="stylesheet" href="../css/perfil.css">
</head>

<body>
    <div class="container">
        <div class="form-image">
            <img src="../img/perfil/perfil.png" alt="">
        </div>
        <div class="form">
            <form action="modificar.php" method="post">
                <div class="form-header">
                    <div class="title">
                        
                        <h1>Mi perfil <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
                            <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
                            <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z"/>
                        </svg></h1>
                    </div>
                    <div class="login-button">
                        <button><a href="home.php">🢀 Regresar</a></button>
                    </div>
                </div>

                <div class="input-group">
                    <!-- <div class="input-box">
                        <label for="correo">Email:</label>
                        <input type="email" name="correo" value="" required>
                    </div> -->

                    <div class="input-box">
                        <label for="nombre">Nombre completo:</label>
                        <input type="text" name="nombre" value="<?php echo $sesion['nombre'];?>" required>
                    </div>
                    <div class="input-box">
                        <label for="celular">Celular:</label>
                        <input type="text" name="celular" value="<?php echo $sesion['celular'];?>" required>
                    </div>

                    <div class="input-box">
                        <label for="ingreso">Ingreso Mensual:</label>
                        <input type="text" name="ingreso" value="<?php echo $sesion['ingreso'];?>" required>
                    </div>

                    <div class="input-box">
                        <label for="password">Contraseña:</label>
                        <input type="text" name="password" value="<?php echo $sesion['password'];?>" required>
                    </div>

                </div>

                <div class="continue-button">
                    <button type="submit" name="modificar"><span>Actualizar mi cuenta</span></button>
                    <input type="hidden" value="true" name="editar" />
                    <!-- <input type="submit" name="modificar" value="Actualizar mi cuenta"> -->
                </div>
            </form>
        </div>
    </div>
</body>

</html>