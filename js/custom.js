/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function validar(form){
    if(form.codigo.value.length <= 0 || form.nombre.value.length <= 0) {
        alert("campos incompletos");
        return false;
    }
    
    form.action = "servidor.php";
    form.method = "POST";
    form.submit();
    
    return true;
}