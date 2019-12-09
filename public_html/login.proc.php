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
        while ($res = mysqli_fetch_array($q)) {
            $estado = $res["estado_usuarios"];
        }
        $row_cnt = mysqli_num_rows($q);

        //Comprobar que el usuario está registrado
        if (!empty($q) && $row_cnt == 1) {
            if($estado=='enabled'){
                session_start();
                $_SESSION['nombre'] = $myusername;
                header("Location: principal.php");
            }else if($estado=='disabled'){
                echo "<script type='text/javascript'>alert('El usuario está dado de baja, contacte con un admin')</script>";
                header('Refresh:0; url = index.php?us=' . $myusername);
            }else{
                echo "<script type='text/javascript'>alert('El usuario ha sido eliminado')</script>";
                header('Refresh:0; url = index.php?us=' . $myusername);
            }
        } else {
            echo "<script type='text/javascript'>alert('Usuario o contraseña incorrectos')</script>";
            header('Refresh:0; url = index.php?us=' . $myusername);
        }
        $close = mysqli_close($connexion);
    } else {
        header("Location: index.php");
    }
}