<?php
$utf8 = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');
/* Definir las variables para la conexion al PDO */
	define('DB_HOST', 'localhost');
	define('DB_NAME', 'sh');
	define('DB_USER', 'root');
	define('DB_PASSWORD', '');

	try {
		$cnnPDO = new PDO("mysql:host=" . DB_HOST . "; dbname=" . DB_NAME, DB_USER, DB_PASSWORD,$utf8);
        $cnnPDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	} catch (PDOException $e) {
		echo "Error de conexión: " . $e->getMessage();
	}
?>