<?php
include("conexion.php"); 

$nombre=$_GET["us"];

//Obtenemos el estado del usuario para dar de alta o baja segun su estado
$sql= mysqli_query($connexion, "SELECT * FROM tbl_usuarios WHERE nombre_usuarios='$nombre'");
while ($res = mysqli_fetch_array($sql)) {
    $estado = $res["estado_usuarios"];
}

//Hacemos una consulta o otra dependiendo de su estado
if($estado=='enabled'){
    $sqlupdate=mysqli_query($connexion, "UPDATE tbl_usuarios SET estado_usuarios='disabled' WHERE nombre_usuarios='$nombre'");
}else{
    $sqlupdate=mysqli_query($connexion, "UPDATE tbl_usuarios SET estado_usuarios='enabled' WHERE nombre_usuarios='$nombre'");
}

//Redirección
header("Location: usuarios.php");

//Cerramos conexion a la base de datos
$mysqli_close = mysqli_close($connexion);
