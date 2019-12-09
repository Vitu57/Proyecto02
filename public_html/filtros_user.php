<?php


//Declaramos variables
$filtro=$_REQUEST["filtro"];
echo $filtro;

//le devolvemos fl, que indicara el tipo de filtro que ha hecho el usuario
header('Location: usuarios.php?fl='.$filtro);





