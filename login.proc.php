<?php
   //se incluye la pagina conexion.php para poder recoger la conexión a la BD
   include("conexion.php");
   
   if ($_SERVER["REQUEST_METHOD"] == "POST") {
    session_start();
    //Declarar variables y hacer request del formulario

    $myusername = $_REQUEST['username'];
    $mypassword = $_REQUEST['password'];
    $pass = md5($mypassword);

    if (isset($_REQUEST["username"])) {
        $q = mysqli_query($connexion, "SELECT * FROM tbl_usuarios WHERE nombre_usuarios = '$myusername' AND pwd_usuarios = '$pass'");
        $row_cnt = mysqli_num_rows($q);

        //Comprobar que el usuario está registrado
        if (!empty($q) && $row_cnt == 1) {
            session_start();
            $_SESSION['nombre'] = $myusername;
            header("Location: principal.php");
        } else {
            echo"<script type='text/javascript'>alert('Usuario o contraseña incorrectos')</script>";
            header('Refresh:0; url = index.php?us=' . $myusername);
        }
        $close = mysqli_close($connexion);
    } else {
        header("Location: index.php");
    }
}