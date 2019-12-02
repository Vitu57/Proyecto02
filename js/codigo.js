
function ValidacionLogin(){
	var user = document.getElementById('username').value;
	var pass = document.getElementById('password').value;
	if(user=='' && pass==''){
		document.getElementById('alerta').innerHTML = 'El campo usuario y contraseña son obligatorios';
                document.getElementById('username').style.border = '2px solid red';
                document.getElementById('password').style.border = '2px solid red';
		document.getElementById('alerta').style.display = 'block';
		return false;
	}else if(user == ''){
		document.getElementById('alerta').innerHTML = 'El campo usuario es obligatiorio';
                document.getElementById('username').style.border = '2px solid red';
                document.getElementById('password').style.border = '1px solid #ccc';
		document.getElementById('alerta').style.display = 'block';
		return false;
	}else if(pass == ''){
		document.getElementById('alerta').innerHTML = 'El campo contraseña es obligatiorio';
                document.getElementById('username').style.border = '1px solid #ccc';
                document.getElementById('password').style.border = '2px solid red';
		document.getElementById('alerta').style.display = 'block';
		return false;
	}else{
		return true;
	}
	
}

function executeJS(id,nom,tipo)
{
    var b = document.getElementById('nrecurso'); 
    b.value = nom;
    var a = document.getElementById('info').setAttribute("value", id);
    var c = document.getElementById('mensaje_incidencia').innerHTML = "Abrir incidencia de " + tipo + " de " + nom
}

var td = document.getElementsByTagName("td");
for (var i = 0; i < td.length; i++) {
    if (td[i].innerHTML == 'disponible'){
        td[i].style.backgroundColor = "green";
        td[i].style.color = "white";
    } else if (td[i].innerHTML == 'ocupado'){
    	td[i].style.backgroundColor = "red";
        td[i].style.color = "white";
    } else if (td[i].innerHTML == 'incidencia'){
    	td[i].style.backgroundColor = "#F4A039";
        td[i].style.color = "white";
    }   
}


function SelectAll(ele,id) {
     var table = document.getElementById(id);
     var checkboxes = table.getElementsByTagName('input');
     if (ele.checked) {
         for (var i = 0; i < checkboxes.length; i++) {
             if (checkboxes[i].type == 'checkbox' && checkboxes[i].disabled == false) {
                 checkboxes[i].checked = true;
             }
         }
     } else {
         for (var i = 0; i < checkboxes.length; i++) {
             console.log(i)
             if (checkboxes[i].type == 'checkbox') {
                 checkboxes[i].checked = false;
             }
         }
     }
 }

function ValidacionIncidencia(){
    var desc = document.getElementById('desc').value;
        if(desc == ''){
        document.getElementById('alerta').innerHTML = 'Introduce una descripción de la incidencia';
                document.getElementById('desc').style.border = '2px solid red';
                return false;
        }else{
            return true;
        }
}