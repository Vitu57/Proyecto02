<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" href="css/estilos.css">
    <meta charset="UTF-8">
</head>
<body>
	<!-- Barra de Navegacion -->

            <?php
            include "header.php";
            ?>



<table border="1" class="tabla">
<?php
//Conectamos a la base de datos
    require_once 'conexion.php';
    
//Coger el id del usuario
$nombre_user= $_SESSION['nombre'];
$sql_user = mysqli_query($connexion, "SELECT id_usuarios FROM tbl_usuarios WHERE nombre_usuarios='$nombre_user'");
while ($res = mysqli_fetch_array($sql_user)) {
    $id_user = $res["id_usuarios"];
}
//Creamos la consulta de los registros del usuario
    $userb=$_SESSION['nombre'];
    $sql = mysqli_query($connexion, "SELECT R.id_reservas, R.inicio_reservas, R.final_reservas, T.nombre_recursos FROM tbl_reservas R LEFT JOIN tbl_recursos T ON R.id_recursos=T.id_recursos WHERE R.id_usuarios='$id_user'");
//Mostrar la tabla
    echo '<th align="center" colspan="4">Historial</th>';
    echo '<tr class="tabla">';
    echo '<th class="tabla">ID</th>';
    echo '<th class="tabla">INICIO</th>';
    echo '<th class="tabla">FINAL</th>';
    echo '<th class="tabla">RECURSO</th>';
    echo '</tr>';
    while ($res = mysqli_fetch_array($sql)) {
                    echo '<tr class="tabla">';
                    echo '<th class="tabla">' . $res["id_reservas"] . '</th>';
                    echo '<th class="tabla">' . $res["inicio_reservas"] . '</th>';
                    if ($res["final_reservas"]==NULL){
                        echo '<th class="tabla">' . 'Reserva en curso' . '</th>';
                    }else{
                        echo '<th class="tabla">' . $res["final_reservas"] . '</th>';
                    }
                    echo '<th class="tabla">' . $res["nombre_recursos"] . '</th>';
                    echo '</tr>';
    }
?>
</table>


