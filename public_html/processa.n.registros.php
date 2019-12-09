<?php
$numuser=1;
$cont=1;
$usernum = $_REQUEST["usuariostotales"];
for ($numuser == 1; $numuser <= $usernum; $numuser++) {
//Declarar variables
        include 'conexion.php';
        $username = $_REQUEST["username" . $cont];
        $password = $_REQUEST["password" . $cont];
        $hash = md5($password);
        $password_verify = $_REQUEST["password_verify" . $cont];
        $hash_verify = md5($password_verify);
        $tipo_user = $_REQUEST["filtro_tipo" . $cont];
//Insertamos el registro del usuario
        //Comprobar que el usuario no esta en uso
        $q = mysqli_query($connexion, "SELECT * FROM tbl_usuarios WHERE nombre_usuarios = '$username'");
        $row_cnt = mysqli_num_rows($q);
        if ($row_cnt == 0) {
            $sql = mysqli_query($connexion, "INSERT INTO `tbl_usuarios`(`nombre_usuarios`, `pwd_usuarios`, `estado_usuarios`, `perfil`) VALUES ('$username','$hash','enabled','$tipo_user')");
        } else {
            echo"<script type=\"text/javascript\">alert('Aviso! Uno o mas usarios en uso'); window.location='registro.n.registros.php';</script>";
        }
    $cont++;   
}
echo "<a href='usuarios.php'>Volver</a>&nbsp;&nbsp;";