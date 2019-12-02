<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" href="https://dev-style.agentfirecdn.com/bootstrap.client.css">
	<link rel="stylesheet" href="https://dev-style.agentfirecdn.com/bootstrap.admin.css">
	<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'>
	<link rel="stylesheet" href="css/estilos.css">
</head>
<body>
<!-- Empieza el menu con distintos div para agrupar cada elemento -->
<div class="simple-admin">
	<div data-component="sidebar">
    	<div class="sidebar">
      		<!-- Comienzo de la tabla para las imagenes del menu -->
      		<ul class="list-group flex-column d-inline-block first-menu">
      			<!-- Primera opcion -->
        		<li class="list-group-item py-2">
        			<!-- Redireccionamiento correspondiente al elemento -->
        			<a href="principal.php">
          				<!-- Imagen del menu y texto que se muestra cuando se desplega -->
            			<img src="imagenes/reservas.png" height="40" class="mr-4"><span>Reservas</span>
        			</a>
        		</li> <!-- Final de la primera opcion -->
        		<!-- Segunda opcion -->
        		<li class="list-group-item py-2">
        			<!-- Redireccionamiento correspondiente al elemento -->
        			<a href="historial.php">
          				<!-- Imagen del menu y texto que se muestra cuando se desplega -->
            			<img src="imagenes/historial.png" height="40"class="mr-4"><span>Historial</span>
        			</a>
        		</li> <!-- Final de la segunda opcion -->
        		<!-- Ahora inciamos un php para que dependiendo del usuario se muestre el elemento de Incidencias -->
				<?php
				// Necesitamos incluir el archivo conexion.php para conectarnos con la base de datos 
				include "conexion.php";
				// Creamos la variable name y le asignamos el valor del nombre del usuario de la sesión actual para luego hacer la consulta
				$name=$_SESSION["nombre"];
				// Creamos la variable txt_qry_all y guardamos en ella la consulta que nos devolverá o el nombre del usuario de la sesión actual o null si el usuario no tiene los privilegios suficientes para que se muestre el botón de Incidencias
				$txt_qry_all="SELECT nombre_usuarios FROM tbl_usuarios WHERE nombre_usuarios='$name' and admin_usuarios=1 OR nombre_usuarios='$name' and informatico_usuarios=1";
				// Creamos la variable txt_qry_admin y guardamos en ella la consulta que nos devolverá o el nombre del usuario de la sesión actual o null si el usuario no tiene los privilegios suficientes para que se muestre el botón de Usuarios
				$txt_qry_admin="SELECT nombre_usuarios FROM tbl_usuarios WHERE nombre_usuarios='$name' and admin_usuarios=1";
				// Ahora hacemos la consulta a nuestra base de datos con la consulta que hemos echo anteriormente
				$qry_res_all=mysqli_query($connexion,$txt_qry_all);
				// Realizamos la consulta de nuevo pero la guardamos en otra variable para solucionar un error en los if
				$qry_res_all2=mysqli_query($connexion,$txt_qry_all);
				// Ahora hacemos la consulta a nuestra base de datos con la consulta que hemos echo anteriormente
				$qry_res_admin=mysqli_query($connexion,$txt_qry_admin);
				// Ahora en este if combrobamos si la consulta está vacia, si contiene algo (será el nombre del usuario actual) o por lo contrario no entrará y no mostrará el botón de Incidencias
				if (null!=(mysqli_fetch_array($qry_res_all))){
					// Como estamos dentro de un php, para que se nos muestre el codigo html tenemos que hacer un echo
					
			        echo '<li class="list-group-item py-2">
			        		<!-- Redireccionamiento correspondiente al elemento -->
				        	<a href="incidencias.php">
				        		<!-- Imagen del menu y texto que se muestra cuando se desplega -->
				            	<img src="imagenes/incidencias.png" height="40" class="mr-4"><span>Incidencias</span>
				        	</a>
				          </li>';
				}
				if (null!=(mysqli_fetch_array($qry_res_admin))) {
					echo '<li class="list-group-item py-2">
			        		<!-- Redireccionamiento correspondiente al elemento -->
				        	<a href="usuarios.php">
				        		<!-- Imagen del menu y texto que se muestra cuando se desplega -->
				            	<img src="imagenes/usuarios.png" height="40" class="mr-4"><span>Usuarios</span>
				        	</a>
				          </li>
				          <!-- El último li nos sirve para que el botón de cerrar sesión del menú se muestre a la altura correcta si incluimos el botón de Incidencias -->
				          <li class="list-group-item py-2"  style="margin-top: 305.5px">';
				}elseif (null!=(mysqli_fetch_array($qry_res_all2))){
					// Si la consulta está vacia entraremos aquí, este comando hace que el botón de cerrar sesión se muestre de forma correcta
					echo '<li class="list-group-item py-2"  style="margin-top: 370px">';
				}else{
					// Si la consulta tiene datos entraremos aquí, este comando hace que el botón de cerrar sesión se muestre de forma correcta
					echo '<li class="list-group-item py-2"  style="margin-top: 435px">';
				}
				
				?>
					<!-- Redireccionamiento correspondiente al elemento -->
        			<a href="logout.php">
        				<!-- Imagen del menu y texto que se muestra cuando se desplega -->
            			<img src="imagenes/logout.png" height="40" class="mr-4"><span>Cerrar sesión de <?php echo $_SESSION['nombre'];?></span>
        			</a>
        		</li> <!-- Final de la tercera opcion -->  
    		</ul>
    	</div>
	</div>
</div>
<!-- Scripts necesarios para el menu -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha.6/js/bootstrap.min.js"></script>
</body>
</html>
