<?php
include("conexion.php");

if(isset($_POST['fecha'])){
    session_start(); //recupera la sesión actual
    $usuario = $_SESSION['nombre']; //asigna el nombre de sesión a la variable $usuario
    $idrecurso = $_REQUEST["idrecurso"];
    $fecha_inicio = $_REQUEST["reserva_inicio"];
    $hora_inicio = $_REQUEST["hora_inicio"] . ":00:00";
    $fecha_final = $_REQUEST["reserva_final"];
    $hora_final = $_REQUEST["hora_final"] . ":00:00";
    $actual = date("Y-m-d H:i:s");
    $cont=0;
    
    $sqlfecha = mysqli_query($connexion,"SELECT inicio_reservas, final_reservas, id_recursos FROM tbl_reservas");
    while(($res = mysqli_fetch_array($sqlfecha))) {
        if(($fecha_inicio . " " . $hora_inicio)>=$res["inicio_reservas"] and ($fecha_inicio . " " . $hora_inicio)<$res["final_reservas"] and $res["id_recursos"]==$idrecurso){
            echo "<script type='text/javascript'>alert('El recurso esta ocupado para las fechas seleccionadas')</script>";
            $cont=1;
            header('Refresh:0; url = principal.php');
        }
    }
    if($cont==0){
        $selestado="SELECT estado_recursos FROM tbl_recursos WHERE id_recursos = '$idrecurso'"; 
        $sql_query_estado=mysqli_query($connexion, $selestado);
        while(($estado = mysqli_fetch_array($sql_query_estado))) {
            $sqlinsert = mysqli_query($connexion, "INSERT INTO `tbl_reservas` (`inicio_reservas`, `final_reservas` ,`id_recursos`, `id_usuarios` ) VALUES ('$fecha_inicio $hora_inicio', '$fecha_final $hora_final', '$idrecurso', (SELECT `id_usuarios` FROM `tbl_usuarios` WHERE `nombre_usuarios`='".$usuario."'))");
        }
        header('Location: principal.php');
    }
    
}

if(isset($_POST['save3']))
    {
		session_start();
		$usuario = $_SESSION['nombre']; 
		$fecha = date('Y-m-d H:i:s');
		$checkbox1=$_POST['recurso'];   
		foreach($checkbox1 as $chk1)  
		{  
		   	$selestado="SELECT estado_recursos FROM tbl_recursos WHERE `tbl_recursos`.`id_recursos` = $chk1";
		   	echo $selestado;
		   	$sql_query_estado=mysqli_query($connexion, $selestado);
		    while(($estado = mysqli_fetch_array($sql_query_estado))) 
		    {
		      	
			     
			    $update="UPDATE `tbl_recursos` SET `estado_recursos` = 'disponible' WHERE `tbl_recursos`.`id_recursos` = $chk1";
			    $sql_query_update=mysqli_query($connexion, $update);
			    $update_fecha ="UPDATE `tbl_incidencias` SET `final_incidencias` = '$fecha'  WHERE `tbl_incidencias`.`id_recursos` = $chk1";
			    $sql_query_update=mysqli_query($connexion, $update_fecha);
		    }
		         
		}
		header('Location: principal.php');  
	}
