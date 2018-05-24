/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function validar(form){
    if(form.codigo.length <= 0 || form.nombre.length <= 0) {
        return false;
    }
    
    form.action = "servidor";
    form.method = "POST";
    form.submit();
    
    return true;
}