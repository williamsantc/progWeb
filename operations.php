<?php
require './QueryReflect/conect.php';
require './QueryReflect/QueryReflectPHP.php';
require './clases/prueba.php';

$array = filter_input_array(INPUT_POST);
switch ($array["operacion"]) {
    case "registrar":
        $obj = new prueba();
        foreach ($array as $clave => $valor) {
            $obj->$clave = $valor;
        }
        echo $obj->RegistrarMySQL($obj);
        break;
    
    case "listar":
        echo (new prueba())->Listar();
        break;
    default :
        echo "Ocurrió un error";
        break;
}