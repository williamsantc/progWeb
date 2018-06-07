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

function money() {
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

function moneda(num) {
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

function validarSesion() {
    if (validarCampos()) {
        alert("Campos No Validos, verifique que no esten vacios.");
    } else {
        document.getElementById("operacion").value = "inicio";
        var adm = document.getElementById("formulario");
        adm.method = "POST";
        adm.action = location.pathname;
        adm.submit();

    }
}

function valcamp(form) {
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

function registrarMVC() {
    
    form = document.getElementById("formData");
    var confir = valcamp(form);
    if (confir) {
        alert("campos incompletos");
        return false;
    }

    if (confirm("¿Almacenar información?")) {
        
         
        var p = document.createElement("input");

        // Agrega el elemento nuevo a nuestro formulario. 
        form.appendChild(p);
        p.name = "operacion";
        p.id = "operacion";
        p.type = "hidden";
        p.value = "registrar";
        
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

        var data = $("form").serialize();
        $.post("operations.php", 

        data, 

        function(result){
            result = result.trim();
            alert(result);
            if(result === "Registro existoso") {
                limpiarFormulario();
                listarMVC();
            }

        });

        return true;
    }

    return false;
}

function modificarMVC() {
    
    form = document.getElementById("formData");
    var confir = valcamp(form);
    if (confir) {
        alert("campos incompletos");
        return false;
    }

    if (confirm("¿Almacenar información?")) {
        
         
        var p = document.createElement("input");

        // Agrega el elemento nuevo a nuestro formulario. 
        form.appendChild(p);
        p.name = "operacion";
        p.id = "operacion";
        p.type = "hidden";
        p.value = "modificar";
        
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

        var data = $("form").serialize();
        $.post("operations.php", 

        data, 

        function(result){
            result = result.trim();
            alert(result);
            
            if(result === "Modificacion exitosa") {
                limpiarFormulario();
                listarMVC();
            }

        });

        return true;
    }

    return false;
}

function listarMVC() {
    $.ajax({url: 'operations.php'
            , type: "POST"
            , data: {
                operacion: "listar"
            }, error: function () {
                limpiarFormulario();
            }, success: function (responseText) {
                responseText = responseText.trim();
            $("#tableList").html(responseText);
            $('#tableData').paging({limit: 10});
            }
        
    });
}

function registrar(form) {
    var confir = valcamp(form);
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
    var confir = valcamp(form);
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
    var confir = valcamp(form);
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
                    $("#btnModificar").attr("disabled",false);
                    $("#btnRegistrar").html("Nuevo");
                    $("#btnRegistrar").attr("onclick", "limpiarFormulario();");
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
     $("#btnModificar").attr("disabled",true);
     $("#btnRegistrar").html("Registrar");
     $("#btnRegistrar").attr("onclick", "registrarMVC();");
}

//Funciones personalizadas

function printEX(form) {
    var confir = valcamp(form);
    if (confir) {
        alert("campos incompletos");
        return false;
    }

    var p = document.createElement("input");
    // Agrega el elemento nuevo a nuestro formulario. 
    form.appendChild(p);
    p.name = "operacion";
    p.id = "operacion";
    p.type = "hidden";
    p.value = "imprimir";

    form.method = "POST";
    form.target = "_blank";
    form.action = location.pathname;
    form.submit();
    return true;
}

function PrintFactura(form) {
    form.target = "_blank";
    form.method = "POST";
    form.action = "../Envio/PrintFactura.php";
    form.submit();

}

function PrintReparto(form) {
    form.target = "_blank";
    form.method = "POST";
    form.action = "../Envio/PrintReparto.php";
    form.submit();

}

function FormFactura(form) {
    form.method = "POST";
    form.action = "../Envio/formEnvio.php";
    form.submit();

}

function FormCortesia(form) {
    form.method = "POST";
    form.action = "../Envio/cortesia.php";
    form.submit();

}

function anulFact(form) {
    var confir = valcamp(form);
    if (confir) {
        alert("campos incompletos");
        return false;
    }

    if (confirm("¿Almacenar información?")) {
        var p = document.createElement("input");
        // Agrega el elemento nuevo a nuestro formulario. 
        form.appendChild(p);
        p.name = "op";
        p.id = "op";
        p.type = "hidden";
        p.value = "anulFact";

        form.method = "POST";
        form.action = location.pathname;
        form.submit();
        return true;
    }
    return false;
}

function updRep(form) {
    var confir = valcamp(form);
    if (confir) {
        alert("campos incompletos");
        return false;
    }

    if (confirm("¿Almacenar información?")) {
        var p = document.createElement("input");
        // Agrega el elemento nuevo a nuestro formulario. 
        form.appendChild(p);
        p.name = "op";
        p.id = "op";
        p.type = "hidden";
        p.value = "updRep";

        form.method = "POST";
        form.action = location.pathname;
        form.submit();
        return true;
    }
    return false;
}
function anulRep(form) {
    var confir = valcamp(form);
    if (confir) {
        alert("campos incompletos");
        return false;
    }
    if (confirm("¿Almacenar información?")) {
        var p = document.createElement("input");
        // Agrega el elemento nuevo a nuestro formulario. 
        form.appendChild(p);
        p.name = "op";
        p.id = "op";
        p.type = "hidden";
        p.value = "anulRep";

        form.method = "POST";
        form.action = location.pathname;
        form.submit();
        return true;
    }
    return false;
}

function FormModFactura(form) {
    var confir = valcamp(form);
    if (confir) {
        alert("campos incompletos");
        return false;
    }

    form.method = "POST";
    form.action = "../Envio/modEnvio.php";
    form.submit();
    return true;
}

