<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->

    <head>
        <title>Registro Usuarios</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="./css/estilos.css">
    </head>
    <script type="text/javascript">
        function ValidacionRegistroUser(){
        var usuarios_totales = document.getElementById('usuariostotales').value;
        var usernum = '1';
        var cont = '0';
        var validacion = new Array();
        var i= '0';
        var estado;
        for (cont==0;cont<usuarios_totales;cont++){
            var user = document.getElementById('username' + usernum).value;
            var pass = document.getElementById('password' + usernum).value;
            var pass_ver = document.getElementById('password_verify' + usernum).value;
            if (user == '') {
                estado='validado';
                validacion[i]=estado;
            }else if(pass == ''){
                document.getElementById('alerta' + usernum).innerHTML = 'Introduce una contraseña';
                document.getElementById('password'  + usernum).style.border = '2px solid red';
                estado='novalidado';
                validacion[i]=estado;
            }else if (pass_ver != pass) {
                document.getElementById('alerta'  + usernum).innerHTML = 'Las contraseñas no coinciden';
                document.getElementById('username'  + usernum).style.border = '1px solid #ccc';
                document.getElementById('password'  + usernum).style.border = '2px solid red';
                document.getElementById('password_verify'  + usernum).style.border = '2px solid red';
                document.getElementById('alerta'  + usernum).style.display = 'block';
                estado='novalidado';
                validacion[i]=estado;
            }else if (user != '' && pass != '' && pass_ver!= ''){
                estado='validado';
                validacion[i]=estado;
            }
            i++;
        usernum++;   
    }
    //Validacion una vez tenemos el array de las comprobaciones
    i='0';
    var check='0';
    for (i=0;i<validacion.length;i++){
        if(validacion[i]=='novalidado'){
            var check='1';
        }
    }
    if (check==0){
        return true;
    }else{
        return false;
    }
}
    </script>
    <body>
        <button class="boton" onclick="location.href='usuarios.php'" style="position: absolute; top:10%; left:90%; top:2%; height: 40px;">
        <b>Atrás</b>
        </button><br><br><br>
        <div align="center">
        <p>Numero de usuarios a registrar:</p><br>
        <form id='login1' action='registro.n.usuarios.php' method='post' accept-charset='UTF-8'>
            <input type="number" id="users" name="users" min="1" max="8" value="1"/>
            <button type="submit">Enviar</button>
        </form>
        </div>
        <div>
        <br>
        <?php
        if(isset($_REQUEST['users'])){
            include 'conexion.php';
            $user=$_REQUEST['users'];
            $cont=1;?>
        <form id="login2" action="processa.n.registros.php" method="post" accept-charset="UTF-8" onsubmit = "return ValidacionRegistroUser()"><br>
            <?php
            echo "<input type='hidden' id='usuariostotales' value='" . $user . "'name='usuariostotales'>";
            while($cont<=$user){
                $sql = mysqli_query($connexion, "SELECT * FROM tipo_usuario");
                echo  '<b>' . 'Usuario ' . $cont .  ':<b>' . '<br><br>';
                echo '<b>' . '<label>Nombre:</label>' .'<br>';
                echo '<input type="text" id="username' . $cont . '" name="username' . $cont . '" max="50"/>'  . '<br><br>';
                echo '<b>' . '<label>Password</label>' .'<br>';
                echo '<input type="password" id="password' . $cont . '" name="password' . $cont . '"/>'  . '<br><br>';
                echo '<b>' . '<label>Confirmar Password</label>' .'<br>';
                echo '<input type="password" id="password_verify' . $cont . '" name="password_verify' . $cont . '"/>'  . '<br><br>';
                echo '<b>' . '<label>Perfil</label>' .'<br>';
                echo '<br>';
                echo '<select name="filtro_tipo' . $cont . '">';
                while ($res = mysqli_fetch_array($sql)){
                echo '<option value="' . $res["id"] . '">' . $res["nombre"] . '</option>';
                }
                echo '</select>' . '<br>';
                echo '<p id="alerta' . $cont . '" class="alerta" style="color:red;" ></p><br><br>';
                $cont=$cont+1;
            }
            echo '<button class="boton" type="submit">Dar de alta</button>' . '<br>' . '</form>';
        }
        ?>
        </div>
    </body>
</html>
        