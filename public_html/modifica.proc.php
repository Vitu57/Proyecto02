<?php
include 'conexion.php';

$iduser = $_REQUEST["iduser"];
$tipo_user = $_REQUEST["tipo_user"];

if($tipo_user=='A'){
    $sql = mysqli_query($connexion, "UPDATE tbl_usuarios SET perfil=1 WHERE id_usuarios='$iduser'");
}else if($tipo_user=='N'){
    $sql = mysqli_query($connexion, "UPDATE tbl_usuarios SET perfil=3 WHERE id_usuarios='$iduser'");
}else if($tipo_user=='M'){
    $sql = mysqli_query($connexion, "UPDATE tbl_usuarios SET perfil=2 WHERE id_usuarios='$iduser'");
}

header('Location: usuarios.php');

        
