/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function envioServidor(form) {
    
    cedula = $("#cedula").val().trim();
    nombre = $("#nombre").val().trim();
    
    if(cedula.length <= 0 || nombre.length <= 0) {
        alert("campos incompletos");
        return false;
    }
    
    form.action = "servidor.php";
    form.method = "GET";
    form.submit();
    return true;
    
    
}