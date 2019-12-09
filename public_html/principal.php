<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" href="css/estilos.css">
    <script type="text/javascript" src="js/codigo.js"></script>
</head>
<body>
	<!-- Barra de Navegacion -->
    <?php
    include "header.php";
    ?>

 <!-- Filtros -->
<form action="filtros.php" method="post">
    <input type="checkbox" name="sala" value="S" <?php
    if (isset($_GET['fl'])) {
        $var = $_GET['fl'];
        if ($var == 'S' || $var == 'C') {
            echo "checked";
        }
    }
        ?>> Salas
    <input type="checkbox" name="objeto" value="O" <?php
    if (isset($_GET['fl'])) {
        $var = $_GET['fl'];
        if ($var == 'O' || $var == 'C') {
            echo "checked";
        }
    }
    ?>> Objeto
    <input class="boton" type="submit" value="Filtrar">
</form><br>
<!--------------------------------Tabla de reservas general --------------------------------------->
<table class="tabla">
    <?php
    //Conectamos a la base de datos
    require_once 'conexion.php';
    
    //Si la variable que devuelve filtros.php no esta inicializada que me muestre todos los recursos, en caso contrario que me muestre los recursos que ha filtrado el usuario
    if (!isset ($_GET['fl'])){
        $filtro='C';
    }else{
        $filtro=$_GET['fl'];
    }
    
    //Hacemos un switch para las querys, segun el filtro hará una consulta diferente
    switch ($filtro) {
            case 'C' :
                $orderby = '';
                break;
            case 'S' :
               $orderby = "where tbl_tiporecursos.nombre_tiporecursos = 'Sala'";
                break;
            case 'O' :
               $orderby = "where tbl_tiporecursos.nombre_tiporecursos = 'Objeto'";
                break;
        }
    //Hacemos un UPDATE de estados de recursos segun la tabla reservas de todos los usuarios
        $actual= date("Y-m-d H:i:s");
        $sqlfecha = mysqli_query($connexion,"SELECT inicio_reservas, final_reservas, id_recursos FROM tbl_reservas");
        while(($res_estado = mysqli_fetch_array($sqlfecha))){
            $idrecurso1=$res_estado["id_recursos"];
            $cont=0;
            if($actual>=$res_estado["inicio_reservas"] and $actual<$res_estado["final_reservas"]){
                 $sqlupdate = mysqli_query($connexion, "UPDATE `tbl_recursos` SET `estado_recursos` = 'ocupado' WHERE `id_recursos` = '$idrecurso1'");
                 $cont=1;
            }else if($actual>$res_estado["final_reservas"] and $cont==0){
                $sqlupdate2 = mysqli_query($connexion, "UPDATE `tbl_recursos` SET `estado_recursos` = 'disponible' WHERE `tbl_recursos`.`id_recursos` = '$idrecurso1'");
            }
        }
        ?>
<div>
    <!---Tabla de recursos que ven todos los usuarios --->
        <table id="1" border="1">
            <tr>
                <th align='center'colspan="4">Reservas</th>
            </tr>
            <?php
            $usuarios = $_SESSION['nombre'];
            //se incluye la pagina conexion.php para poder recoger la conexión a la BD
            include("conexion.php");
            //consulta para obtener el id del usuario actual
            $id_usuario= "SELECT id_usuarios 
                          FROM tbl_usuarios 
                          WHERE nombre_usuarios = '".$usuarios."'";
                //consulta para mostrar la tabla recursos con su tipo
            $sqlrecursos = "SELECT *, tbl_tiporecursos.id_tiporecursos
                            FROM tbl_recursos 
                            LEFT JOIN tbl_tiporecursos 
                            ON tbl_recursos.id_tiporecursos=tbl_tiporecursos.id_tiporecursos
                            $orderby" ;
            //consulta que muestra la tabla de recursos, su tipo, y las reservas para generar a posteriori la tabla mis reservas
            $sqlrecursos2 = "SELECT R.nombre_recursos,R.estado_recursos, R.id_recursos, L.id_usuarios, L.inicio_reservas, L.final_reservas FROM tbl_reservas L INNER JOIN tbl_recursos R ON L.id_recursos=R.id_recursos";
            $userid = mysqli_fetch_assoc(mysqli_query($connexion, $id_usuario));
            echo "<th align='center'>Nombre del recurso</th>";
            echo "<th align='center'>Estado</th>";
            echo "<th align='center'>Tipo</th>";
            echo "<th align='center'>Reservar</th>";
            echo "</tr>";
            //Ejecución de la consulta para mostrar tabla recursos
            $recursos = mysqli_query($connexion, $sqlrecursos);
            while(($fila = mysqli_fetch_array($recursos)))
            { 
                if($fila['estado_recursos'] == 'disponible' OR $fila['estado_recursos'] == 'ocupado'){
                    ?>
                    <tr>
                        <td><?php echo $fila[1]; ?></td>
                        <?php $idrecurso=$fila[0]; ?>
                        <td><?php echo $fila[2]; ?></td>
                        <td><?php echo $fila[5]; ?></td>
                        <td align="center"><a href="#myModal2" onclick='executeJS(<?php echo '"'.$idrecurso.'"';?>);'><img border="0" title="Reservar" alt="reserva" src="imagenes/calendar.png" width="25" height="25" align="middle"></a></td>
                    </tr>
                        <?php
                }else{
                          ?>
                    <tr>
                        <td><?php echo $fila[1]; ?></td>
                        <td><?php echo $fila[2]; ?></td>
                        <td><?php echo $fila[5]; ?></td>
                        <td style="height: 26.5px;">no disponible</td>
                    </tr>
                        <?php 
                } 
            }     
                        ?>        


    <!--------------------------------Tabla de reservas del propio usuario --------------------------------------->
        </table>
    <br><br>
</div>
<div style="position: absolute; left: 750px; top: 56px">
        <table border="1" id="2">  
            <tr>
                <th align='center' colspan="5">Mis Reservas</th>
            </tr>
            <?php
                
                echo "<th align='center'>Nombre del recurso</th>";
                echo "<th align='center'>Inicio de reserva</th>";
                echo "<th colspan='2'>Final de Reserva</th>";
                echo "</tr>";
                //Ejecución consulta de la tabla de mis reservas
                $recursos2 = mysqli_query($connexion, $sqlrecursos2);
                $hoy = date("Y-m-d H:i:s");
                while(($fila = mysqli_fetch_array($recursos2))){ 
                    $idrecurso = $fila["id_recursos"];
                    if($hoy<=$fila["final_reservas"] and $fila['id_usuarios'] == $userid['id_usuarios']){
                        ?>
                        <tr>  
                            <td><?php echo $fila["nombre_recursos"]; ?></td>
                            <td><?php echo $fila["inicio_reservas"]; ?></td>
                            <td><?php echo $fila["final_reservas"]; ?></td>
                            <td><a href="#myModal" id='enlace' data-id="<?php echo $fila[0];?>" onclick= 'executeJS(<?php echo'"'.$idrecurso.'"';?>)'><img border="0" style="padding-top: 4px;" title="Abrir incidencia" alt="exclamación" src="imagenes/inc.png" width="22" height="22"></a></td>
                        </tr> 
                        <?php
                    }
                }
            ?>
        </table>
</div>
    <div id="myModal" class="modalmask">
            <div style="background-color: #FFFFBF; margin-top: 100px;" class="modalbox movedown" id="resultadoContent">

                <a style="margin-left: 400px; background-color: red;color: white; border: 3px solid red" href="principal.php" title="Close" class="close">X</a>
                <script type="text/javascript" src="js/codigo.js"></script> 
                <form action="incidencias.proc.php" method="post" enctype="multipart/form-data" onsubmit = "return ValidacionIncidencia()">
                    <b><legend>Incidencia</legend></b>
                    <p id='mensaje_incidencia'></p>
                    <input type='hidden' name='idrecurso' id="info" value=""/>
                    <textarea type="text" name='desc' id="desc" placeholder="Descripción de incidencia" style="height: 70px;width:90%;position: relative;"></textarea><br>
                    <p id="alerta" class="alerta" style="text-align: center;"></p>
                    <input type="submit" class="boton" value="Enviar" name="incidencia">                
            </form>
        </div>
    </div>
    <div id="myModal2" class="modalmask">
            <div id="modal2" style="background-color: #FFFFBF; height:430px; margin-top: 100px;" class="modalbox movedown" id="resultadoContent">

                <a style="margin-left: 400px; background-color: red;color: white; border: 3px solid red" href="principal.php" title="Close" class="close">X</a>
                <script type="text/javascript" src="js/codigo.js"></script> 
                <form action="reservar.php" method="post" enctype="multipart/form-data" onsubmit="return ValidacionReserva()">
                    <b><legend>Realizar Reserva</legend></b><br>
                    <input type='hidden' name='idrecurso' id="info2" value=""/>
                    <legend>Fecha inicio de reserva: </legend><br>
                    <input type="date" id="r_i" name="reserva_inicio" step="1" min="<?php echo date("Y-m-d");?>" max="2030-12-31" value="<?php $fechainiciouser=date("Y-m-d");echo $fechainiciouser;?>"><br>
                    <br><legend>Hora inicio reserva: </legend><br>
                    <select id="h_i" name="hora_inicio">
                        <?php
                        $conthorainicio=0;
                        while($conthorainicio<24){
                            ?><option  value="<?php if($conthorainicio<10){echo "0";}echo $conthorainicio;?>"><?php if($conthorainicio<10){echo "0";}echo $conthorainicio . ":00" ?></option><?php
                            $conthorainicio++;
                        }
                        ?>
                    </select><br>
                    <br><legend>Fecha final de reserva: </legend><br>
                    <input type="date" id="r_f" name="reserva_final" step="1" min="<?php echo $fechainiciouser;?>" max="2030-12-31" value="<?php echo date("Y-m-d");?>"><br>
                    <br><legend>Hora final reserva: </legend><br>
                    <select id="h_f" name="hora_final">
                        <?php
                        $conthorafinal=0;
                        while($conthorafinal<24){
                            ?><option  value="<?php if($conthorafinal<10){echo "0";}echo $conthorafinal;?>"><?php if($conthorafinal<10){echo "0";}echo $conthorafinal . ":00" ?></option><?php
                            $conthorafinal++;
                        }
                        ?>
                    </select><br><br>
                    <p id="alerta2" class="alerta" style="text-align: center;"></p>
                    <br><input type="submit" class="boton" value="Reservar" name="fecha">
                    
                </form>
        </div>
    </div>
    <script type="text/javascript">
        function ValidacionReserva(){
        var horainicio = document.getElementById('h_i').value;
        var horafinal = document.getElementById('h_f').value;
        var fechainicio = document.getElementById('r_i').value;
        var fechafinal = document.getElementById('r_f').value;
        var fecha = new Date();
        var hour = fecha.getHours() - 1;
        if (horafinal<=horainicio){
            document.getElementById('alerta2').innerHTML = 'Selecciona una hora final superior a la inicial';
            document.getElementById('h_f').style.border = '2px solid red';
            document.getElementById('modal2').style.height = '460px';
            return false;
        }else if (fechafinal<fechainicio){
            document.getElementById('alerta2').innerHTML = 'Selecciona una fecha final correcta';
            document.getElementById('r_f').style.border = '2px solid red';
            document.getElementById('modal2').style.height = '460px';
            return false;
        }else if (horainicio<=hour){
            document.getElementById('alerta2').innerHTML = 'Selecciona una hora superior a la actual';
            document.getElementById('h_i').style.border = '2px solid red';
            document.getElementById('modal2').style.height = '460px';
            return false;
        }else{
            return true;
        }
    }
    </script>
    <script type="text/javascript" src="js/codigo.js"></script>
 </body>
</html>
