<?php
//Mandar a llamar a la base de datos
    require_once '../db/db.php';
	session_start();
//Mandamos llamar todo los datos almacenados de la cuenta en la variable "Sesion"
    $sesion = $_SESSION['sesion'];
//Muestra el array de todos los datos enviados para registrarse
    var_dump($_POST);
//SI se da click al boton submit con el nombre "modificar" ejecuta el "UpdateQuery"
    if (isset($_POST['modificar']))
    {
        $correo = $_SESSION['sesion']['correo'];
        $nombre=$_POST['nombre'];
        $celular=$_POST['celular']; 
        $ingreso=$_POST['ingreso'];
        $password=$_POST['password'];

        $updateQuery=$cnnPDO->prepare('UPDATE usuarios SET nombre=:nombre, celular=:celular, ingreso=:ingreso, password=:password WHERE correo=:correo');
            
            $updateQuery->bindParam(':correo', $correo);
            $updateQuery->bindParam(':nombre', $nombre);
            $updateQuery->bindParam(':celular', $celular);
            $updateQuery->bindParam(':ingreso', $ingreso);
            $updateQuery->bindParam(':password', $password);

            $updateQuery->execute();
            $sesion['nombre']=$_POST['nombre'];
            $sesion['celular']=$_POST['celular'];
            $sesion['ingreso']=$_POST['ingreso'];
            $sesion['password']=$_POST['password'];
            $_SESSION['sesion'] = $sesion;
            header("location: perfil.php");
    }
?>