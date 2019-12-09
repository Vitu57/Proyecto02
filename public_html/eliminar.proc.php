<?php
include 'conexion.php';

$usuario=$_GET['us'];

$sql_delete = mysqli_query($connexion, "UPDATE tbl_usuarios SET estado_usuarios='eliminado' WHERE nombre_usuarios='$usuario'");

//Redireccion
header("Location: usuarios.php");

//Cerramos conexion a la base de datos
$mysqli_close = mysqli_close($connexion);