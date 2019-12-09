<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" href="css/estilos.css">
    <meta http-equiv="Content-Type" content="text/html">
    <meta charset="utf-8">
    <script type="text/javascript" src="js/codigo.js"></script>
</head>
<body>
	<!-- Barra de Navegacion -->
            <?php
            include "header.php";
            ?>
<br><br><br>
        <form action="filtros_user.php" method="post">
            <p>Tipo de usuario: <select name="filtro" style='display:inline;'>
                <option value='T' <?php 
                if (isset($_GET['fl'])) {
                    if ($_GET['fl']=='T'){
                        echo 'checked';
                    }
                }
                    ?>
                >Todos</option>
                <option value='N' <?php 
                if (isset($_GET['fl'])) {
                    if ($_GET['fl']=='N'){
                        echo 'selected=true';
                    }
                }
                    ?>
                >Normal</option>
                <option value='M' <?php 
                if (isset($_GET['fl'])) {
                    if ($_GET['fl']=='M'){
                        echo 'selected=true';
                    }
                }
                ?>
                >Moderador</option>
                <option value='A' <?php 
                if (isset($_GET['fl'])) {
                    if ($_GET['fl']=='A'){
                        echo 'selected=true';
                    }
                }
                ?>
                >Admin</option>
                </select>
                <input type='submit' value='Enviar'/>
            </p>
        </form>
<table id="3" border="1" class="tabla">
<?php
//Conectamos a la base de datos
    require_once 'conexion.php';
//Si la variable que devuelve filtros.php no esta inicializada que me muestre todos los usuarios activos, en caso contrario que me muestre los filtrados
    if (!isset($_GET['fl'])) {
        $filtro = 'T';
    } else {
        $filtro = $_GET['fl'];
    }
    //Hacemos un switch para las querys, segun el filtro hará una consulta diferente
    switch ($filtro) {
            case 'T' :
                $orderby = "where estado_usuarios <> 'eliminado'";
                break;
            case 'M' :
               $orderby = "where estado_usuarios <> 'eliminado' and T.perfil=2";
                break;
            case 'A' :
               $orderby = "where estado_usuarios <> 'eliminado' and T.perfil=1";
                break;
            case 'N' :
               $orderby = "where estado_usuarios <> 'eliminado' and T.perfil=3";
                break;
        }
//Creación de la tabla segun el fitro
    echo "<tr>";
    echo "<th align='center'>ID Usuario</th>";
    echo "<th align='center'>Nombre</th>";   
    echo "<th align='center'>Estado usuario</th>";
    echo "<th align='center'>Perfil</th>";   
    echo "<th id='opciones'>Opciones</th>";
    echo "</tr>";
    $userb=$_SESSION['nombre'];
    //Consulta
    $sql = mysqli_query($connexion, "SELECT T.id_usuarios, T.nombre_usuarios, T.estado_usuarios, U.nombre FROM tbl_usuarios T INNER JOIN tipo_usuario U ON T.perfil=U.id $orderby");
    //Insertar filas de usuarios
        while ($res = mysqli_fetch_array($sql)) {
            echo '<tr>';
            echo '<th align="center">' . $res["id_usuarios"] . '</th>';
            echo '<th align="center">' . $res["nombre_usuarios"] . '</th>';
            echo '<th align="center">' . $res["estado_usuarios"] . '</th>';
            $iduser=$res["id_usuarios"];
            echo '<th align="center">' . $res["nombre"] . '</th>';
            ?>
            <th align="center"><a href="#myModal" onclick='executeJS(<?php echo '"'.$iduser.'"';?>);'><img border="0" title="Modificar Usuario" alt="modify" src="imagenes/edit.png" width="15" height="15" align="middle"></a>
            <?php
            echo '<form id="form" action="baja.proc.php?us=' . $res["nombre_usuarios"] . '" method="post" accept-charset="UTF-8" style="display:inline;">';
            echo '<input type="image" src="imagenes/exclamacion.png" width="18" height="18" title="Dar de alta o baja" align="middle"/>';
            echo '</form>';
            echo '<form id="form" action="eliminar.proc.php?us=' . $res["nombre_usuarios"] . '" method="post" accept-charset="UTF-8" style="display:inline;">';
            echo '<input type="image" src="imagenes/basuradef.png" width="20" height="20" title="Eliminar Usuario" align="middle"/>';
            echo '</form>';
            echo '</th>';
            echo '</tr>';
        }
    ?>
    <table style='text-align: center; height: 60px;'>
        <tr>
    <?php
    //Botón de agragar nuevos usuarios(Solo se permite a los usuarios de privilegio "admin")
    $sqlpriv=mysqli_query($connexion, "SELECT * FROM tbl_usuarios WHERE nombre_usuarios='$userb'");
    while ($res = mysqli_fetch_array($sqlpriv)){
        $numadmin=$res["perfil"];
    }
    if($numadmin==1){
        ?>
        <br><br><button class="boton" style="height: 40px; width: 150px;"onclick="location.href='registro.n.usuarios.php'">
        <b>Agregar Usuarios</b>
        </button>
        <?php
    }
    ?>
    </tr>
    </table>
        <div id="myModal" class="modalmask">
            <div style="background-color: #FFFFBF; margin-top: 100px;" class="modalbox movedown" id="resultadoContent">

                <a style="margin-left: 400px; background-color: red;color: white; border: 3px solid red" href="usuarios.php" title="Close" class="close">X</a>
                <script type="text/javascript" src="js/codigo.js"></script> 
                <form action="modifica.proc.php" method="post" enctype="multipart/form-data">
                    <legend>Modificar usuario:</legend>
                    <input type='hidden' name='iduser' id="info" value=""/><br>
                    <select name="tipo_user">
                        <option value="A">Administrador</option>
                        <option value="N">Normal</option>
                        <option value="M">Informatico</option>
                    </select>
                    <p id="alerta" class="alerta" style="text-align: center;"></p>
                    <input type="submit" class="boton" value="Enviar" name="incidencia"></td>                
                </form>
        </div>
    </div>
</html>