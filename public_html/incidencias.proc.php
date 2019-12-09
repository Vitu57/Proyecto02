<?php
include("conexion.php"); 

$id_recurso = $_REQUEST["idrecurso"];
$descripcion = $_REQUEST["desc"];

	if(isset($_POST['incidencia'])){
		session_start(); //recupera la sesión actual
                //Coger el id del usuario
                $nombre_user = $_SESSION['nombre'];
                $sql_user = mysqli_query($connexion, "SELECT id_usuarios FROM tbl_usuarios WHERE nombre_usuarios='$nombre_user'");
                while ($res = mysqli_fetch_array($sql_user)) {
                    $id_user = $res["id_usuarios"];
                }
                $fecha = date('Y-m-d H:i:s');//obtiene fecha actual
		
                $insert ="INSERT INTO `tbl_incidencias`( `inicio_incidencias`, `informe_incidencias`, `id_recursos`, `id_usuarios`) VALUES ('$fecha', '$descripcion','$id_recurso','$id_user')";

                $update="UPDATE `tbl_recursos` SET `estado_recursos` = 'incidencia' WHERE `tbl_recursos`.`id_recursos` = $id_recurso";
				$update_historial="UPDATE `tbl_reservas` SET `final_reservas` = '$fecha' WHERE `id_recursos` = $id_recurso";
                $sql_query_update=mysqli_query($connexion, $update);
				$sql_query_update=mysqli_query($connexion, $update_historial);
                $sql_query_insert=mysqli_query($connexion, $insert);
                header('Location: principal.php'); 
		      
		}else{
		         
		header('Location: principal.php');  
                }
