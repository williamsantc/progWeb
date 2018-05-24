/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function norights() {
    $(document).ready(function () {

        $(document).on("contextmenu", function () {
            alert('¡Función no permitida!');
            return false;
        });

    });
}

function fecha() {
    var f = new Date();
    var año = f.getFullYear();
    document.write(año);
}

//Validaciones Esenciales

function validarTextoVacio(cadena) {
    if (cadena == null || cadena.length == 0 || /^\s+$/.test(cadena)) {
        return true;
    } else {
        return false;
    }
}

function validaSoloTexto(cadena) {
    var patron = /^([a-zA-Z]|\s*)*$/;
    if (!cadena.search(patron))
        return true;
    else
        return false;
}

function soloNumeros() {
    $(document).ready(function () {

        $('.n0ee50341').on('keydown', function (e) {
            -1 !== $.inArray(e.keyCode, [46, 8, 9, 27, 13]) || (e.keyCode === 188 && $(this).attr('class').includes("money") && !$(this).val().includes(",")) || (/65|67|86|88/.test(e.keyCode) && (e.ctrlKey === true || e.metaKey === true)) && (!0 === e.ctrlKey || !0 === e.metaKey) || 35 <= e.keyCode && 40 >= e.keyCode || (e.shiftKey || 48 > e.keyCode || 57 < e.keyCode) && (96 > e.keyCode || 105 < e.keyCode) && e.preventDefault()
        });


    });
}

function inputToMoney() {
    $(document).ready(function () {
        $('.money').on('keyup', function () {
            var numero = $(this).val().replace(/\./g, '').trim();
            var parts = numero.split(',');
            var entero = parts[0];
            var decimal = null;
            if (parts.length > 1) {
                decimal = parts[1].substring(0, 2);
            }
            var valores = entero.split('');
            var ret = "";
            var aux = 1;
            if (valores.length > 0) {
                if (valores[0] !== "0") {
                    for (var i = valores.length - 1; i >= 0; i--) {
                        if (aux % 3 === 0 && aux < valores.length) {
                            ret = "." + valores[i] + ret;
                        } else {
                            ret = valores[i] + ret;
                        }
                        aux++;
                    }
                } else {
                    ret = "0";
                }
            } else if (decimal !== null) {
                ret = "0";
            }
            if (decimal !== null) {
                ret += "," + decimal;
            }
            $(this).val(ret);
        });

        $('.money').on('focusout', function () {
            if ($(this).val().length > 0) {
                var parts = $(this).val().split(',');
                if (parts.length === 1 && parts[0].length > 0) {
                    $(this).val($(this).val() + ",00");
                } else if (parts[1].length === 1) {
                    $(this).val($(this).val() + "0");
                }
            }

        });
    });
}

function numberToMoney(num) {
    var numero = $.trim(num);
    var parts = numero.split('.');
    var entero = parts[0];
    var decimal = null;
    if (parts.length > 1) {
        decimal = parts[1].substring(0, 2);
    }
    var valores = entero.split('');
    var ret = "";
    var aux = 1;
    if (valores.length > 0) {
        if (valores[0] !== "0") {
            for (var i = valores.length - 1; i >= 0; i--) {
                if (aux % 3 === 0 && aux < valores.length) {
                    ret = "." + valores[i] + ret;
                } else {
                    ret = valores[i] + ret;
                }
                aux++;
            }
        } else {
            ret = "0";
        }
    } else if (decimal !== null) {
        ret = "0";
    }
    if (decimal !== null) {
        ret += "," + decimal;
    } else {
        ret += ",00";
    }
    return ret;
}

function validaTextoNumeros(cadena) {
    var patron = /^([0-9A-Za-z]|\s*)*$/;
    if (!cadena.search(patron))
        return true;
    else
        return false;
}

function validarCampos(form) {
    var campos = form.elements;
    for (var i = 0; i < campos.length; i++) {
        if (campos[i].id.trim() !== "" && campos[i].tagName !== "BUTTON"
                && campos[i].className.includes("m129f03d0")) {
            if (campos[i].value === "" || campos[i].value === "null") {
                campos[i].focus();
                return true;
            }
        }
    }
    return false;
}

function registrar(form) {
    var confir = ValidarCampos(form);
    if (confir) {
        alert("campos incompletos");
        return false;
    }

    if (confirm("¿Almacenar información?")) {
        
         
        var p = document.createElement("input");
        
        if($(":password").length > 0) {
            $(":password").each(function() {
                
                var pass = document.createElement("input");
                
                pass.type = "hidden";
                pass.name = "hs_" + $(this).attr("id");
                pass.id = "hs_" + $(this).attr("id");
                pass.value = hex_sha512($(this).val());
                
                form.appendChild(pass);
                console.log(p.value + " " + p.id);
                $(this).val("");
            });
        } 
        // Agrega el elemento nuevo a nuestro formulario.
        
        form.appendChild(p);
        p.name = "operacion";
        p.id = "operacion";
        p.type = "hidden";
        p.value = "registrar";

        form.method = "POST";
        form.action = location.pathname;
        form.submit();
        return true;
    }
    return false;
}

function modificar(form) {
    var confir = ValidarCampos(form);
    if (confir) {
        alert("campos incompletos");
        return false;
    }

    if (confirm("¿Almacenar cambios?")) {
        var p = document.createElement("input");
        
        if($(":password").length > 0) {
            $(":password").each(function() {
                
                var pass = document.createElement("input");
                
                pass.type = "hidden";
                pass.name = "hs_" + $(this).attr("id");
                pass.id = "hs_" + $(this).attr("id");
                pass.value = hex_sha512($(this).val());
                
                form.appendChild(pass);
                console.log(p.value + " " + p.id);
                $(this).val("");
            });
        } 
        
        // Agrega el elemento nuevo a nuestro formulario. 
        form.appendChild(p);
        p.name = "operacion";
        p.id = "operacion";
        p.type = "hidden";
        p.value = "modificar";

        form.method = "POST";
        form.action = location.pathname;
        form.submit();
        return true;
    }
    return false;
}

function eliminar(form) {
    var confir = ValidarCampos(form);
    if (confir) {
        alert("campos incompletos");
        return false;
    }

    if (confirm("¿Desea Eliminar?")) {
        var p = document.createElement("input");
       
        // Agrega el elemento nuevo a nuestro formulario. 
        form.appendChild(p);
        p.name = "operacion";
        p.id = "operacion";
        p.type = "hidden";
        p.value = "eliminar";

        form.method = "POST";
        form.action = location.pathname;
        form.submit();
        return true;
    }
    return false;
}


function refresh() {
    location.href = location.pathname;
}

function buscar(id, value) {
    $.ajax({url: '../QueryReflect/QRSearch.php'
            , data: {
                clave: id,
                valor: value
            }, error: function () {
                limpiarFormulario();
                alert("Error en el objeto JSON");
            }, success: function (responseText) {
                limpiarFormulario();
                var rs = responseText.trim();
                console.log(rs);
                var obj = JSON.parse(rs);
                if(typeof obj["error"] === 'undefined') {
                    var data = obj["DATA"];
                    console.log(data);
                    for (var x in data) {
                        if ($('#' + x).length > 0 && !$('#' + x).is("input:password")) { 
                            $('#' + x).val(data[x]);
                        } 
                    }
                    if(typeof obj["NOMAL"] !== 'undefined') {
                        var norm = obj["NOMAL"];
                        console.log(norm);
                        for(var x in norm) {
                            if ($('#' + x).length > 0) { 
                                $('#' + x).prop('checked', true);
                            } 
                        }
                    }
                } else {
                    alert(obj["error"]);
                }
            }
        
    });
}

function limpiarFormulario() {
     $("form").each(function() {
        $(this)[0].reset();
     });
}
