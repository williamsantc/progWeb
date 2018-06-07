<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require './QueryReflect/conect.php';
require './QueryReflect/QueryReflectPHP.php';
require './clases/usuario.php';

$user = new usuario();
$user->codigo_usuario = "123";
$user->nombre_usuario = "johan";
$user->apellido_usuario = "perez";

echo $user->generarCheckboxHTML("SELECT codigo_usuario as clave, nombre_usuario as valor FROM usuario");

