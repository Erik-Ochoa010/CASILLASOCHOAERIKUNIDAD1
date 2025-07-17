<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../css/registro.css" />
    <script src="../js/registro.js" defer></script>
    <title>Registro</title>
    <!-- Icon of the page -->
    <link rel="shortcut icon" href="../img/icon.png" type="image/x-icon">
  </head>
  <body>
    <form action="agregar.php" class="form" method="post">
        <center>
          <h1>Registro</h1>
          <img src="../img/index/logo.png" alt="" width="200px" height="50px" style="text-align: center;">
        </center>
      
      <!-- Progress bar -->
      <div class="progressbar">
        <div class="progress" id="progress"></div>
        
        <div
          class="progress-step progress-step-active"
          data-title="Email"></div>
        <div class="progress-step" data-title="Nombre"></div>
        <div class="progress-step" data-title="Celular"></div>
        <div class="progress-step" data-title="Ingresos"></div>
        <div class="progress-step" data-title="Registrarme"></div>
      </div>

      <!-- Step 1-->
      <div class="form-step form-step-active">
        <div class="input-group">
          <label for="correo"><b><i>Email:</i></b></label>
          <input type="email" name="correo" id="correo" autocomplete="off" required/>
        </div>
        <div class="">
          <a href="#" class="btn btn-next width-50 ml-auto">Continuar 🢂</a>
        </div>
      </div>
      <!-- Step 1-->

      <!-- Step 2-->
      <div class="form-step">
        <div class="input-group">
          <label for="nombre"><b><i>Nombre completo:</i></b></label>
          <input type="text" name="nombre" id="nombre" autocomplete="off" required/>
        </div>
        <div class="btns-group">
          <a href="#" class="btn btn-prev">🢀 Volver</a>
          <a href="#" class="btn btn-next">Continuar 🢂</a>
        </div>
      </div>
      <!-- Step 2-->

      <!-- Step 3-->
      <div class="form-step">
        <div class="input-group">
          <label for="celular"><b><i>Celular:</i></b></label>
          <input type="text" name="celular" id="celular" autocomplete="off" required/>
        </div>
        <div class="btns-group">
          <a href="#" class="btn btn-prev">🢀 Volver</a>
          <a href="#" class="btn btn-next">Continuar 🢂</a>
        </div>
      </div>
      <!-- Step 3-->
      

      <!-- Step 4-->
      <div class="form-step">
        <div class="input-group">
          <label for="ingreso"><b><i>Ingreso Mensual:</i></b></label>
          <input type="text" name="ingreso" id="ingreso" autocomplete="off" required/>
        </div>
        <div class="btns-group">
          <a href="#" class="btn btn-prev">🢀 Volver</a>
          <a href="#" class="btn btn-next">Continuar 🢂</a>
        </div>
      </div>
      <!-- Step 4-->
      

       <!-- Step 5-->
      <div class="form-step">
        <div class="input-group">
          <label for="password"><b><i>Contraseña:</i></b></label>
          <input type="password" name="password" id="password" autocomplete="off" />
        </div>
        <div class="btns-group">
            <a href="#" class="btn btn-prev">🢀 Volver</a>
            <input type="hidden" value="true" name="registrarme" />
            <input type="submit" name="registrarme" value="Registrarme ✔️" class="btn" style="background-color: #ba5143;" />
          </div>
      </div>
      <!-- Step 5-->
    </form>
  </body>
</html>