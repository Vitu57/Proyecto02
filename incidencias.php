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

<form action="reservar.php" method="POST" enctype="multipart/form-data">
<table id="3" border="1" class="tabla">
<?php
//Conectamos a la base de datos
    require_once 'conexion.php';
    $sqlcomment = "SELECT column_comment FROM information_schema.columns WHERE table_name = 'tbl_incidencias' ORDER BY `column_comment` DESC";
    $comments = mysqli_query($connexion, $sqlcomment);
    while(($comment = mysqli_fetch_array($comments, MYSQLI_ASSOC)))
    { 
        if($comment['column_comment']!=="")
                           
        {                       
            foreach ($comment as $head)
            {
                echo "<th align='center'>". $head . "</th>";                        
            }
        }    
    }
    echo "<th id='todo'><label>Todo</label><br><input type='checkbox' onchange='SelectAll(this,3)' name='recurso[]'></th>";
    echo "</tr>";
    
//Creamos la consulta de los registros del usuario
    $sql = mysqli_query($connexion, "SELECT *, tbl_recursos.nombre_recursos 
                                    FROM tbl_incidencias
                                    INNER JOIN tbl_recursos
                                    on tbl_recursos.id_recursos = tbl_incidencias.id_recursos");
//Mostrar la tabla
    while ($res = mysqli_fetch_array($sql)) {
        ?>
                    <tr class="tabla">
                    <td class="tabla"><?php echo$res["id_usuarios"];?></td>
                    <td class="tabla"><?php echo$res["nombre_recursos"];?> </td>
                    <td class="tabla"><?php echo$res["inicio_incidencias"];?> </td>
                    <?php
                    if ($res["final_incidencias"]==NULL){
                        echo '<td class="tabla">' . 'En curso' . '</td>';
                    }else{
                        echo '<td class="tabla">' . $res["final_incidencias"] . '</td>';
                    }
                    ?>
                    
                    <td class="tabla"><?php echo$res["informe_incidencias"];?></td>
                    <td><input type="checkbox" name="recurso[]" value="<?php echo $res[4];?>"></td>
                    </tr>
    <?php 
    }
?>
</table>
<input style="margin-left: 720px; margin-top: 10px;" class="boton" type="submit" value="Liberar" name="save3"></td>
</form>


