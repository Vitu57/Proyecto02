<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Login</title>
        <link rel="stylesheet" href="css/login.css">
    </head>
    <script type="text/javascript" src="js/codigo.js">
    </script>
    <body>
        <center>
        <br><br>
        <form id='login' action='login.proc.php' method='post' accept-charset='UTF-8' onsubmit = "return ValidacionLogin()">
                <table>
                    <tr>
                        <th class="borde"><legend>Login</legend></th>
                        <th><input type='hidden' name='submitted' id='submitted' value='1'/></th>
                    </tr>
                    <tr>
                        <th class="fuenteth"><label for='username' >Nombre de Usuario</label></th>
                        </tr>
                        <tr>
                        <th><input class="cajita" type='text' placeholder="Introduce el usuario" pattern="[a-z]{1,15}" name='username' id='username'  value="<?php 
                                if (isset($_GET['us'])) {
                                    $user=$_GET['us'];
                                    echo "$user";
                                }
                        ?>" maxlength="50"/></th>
                    </tr>
                    <tr>
                        <th class="fuenteth"><label for='password' >Contraseña</label></th>
                    </tr>
                    <tr>
                        <th><input class="cajita" type='password' placeholder="Introduce contraseña" name='password' id='password' maxlength="50"/></th>
                    </tr>
                    
                    <tr>
                        <th><button class="env" type="submit">Entrar</button></th></th>
                    </tr>
                </table>
                <p id="alerta" class="alerta"></p>
                <h2><a href="presentacion.html">Pagina de presentación</a></h2>
        </form>
        </center>
    </body>
</html>
