<!DOCTYPE html>
<html>
<head>
	<title></title>
	  <link rel="stylesheet" href="https://dev-style.agentfirecdn.com/bootstrap.client.css">
<link rel="stylesheet" href="https://dev-style.agentfirecdn.com/bootstrap.admin.css"><link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'><link rel="stylesheet" href="css/estilos.css">

</head>
<body>
		<?php
		//Iniciamos la sesión
		session_start();
		// Comprobamos si la sesión está iniciado con un usuario
		if(isset($_SESSION['nombre'])){
			// Si está iniciada la sesión con un usuario incluimos el menu.php para que se nos muestre el menu
        	include "menu.php";
		}else{
			// Si no está iniciada la sesión con un usuario nos envia a index.php
			header("Location: index.php");
		}
		?>
</body>
</html>