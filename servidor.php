<?php

$a = 36579;
//$e=0;
//for ($i=0; $i< strlen($a);$i++){
//    echo 'listo!!';
//}
$codigo = $_POST["codigo"];
$nombre = $_POST["nombre"];

echo $codigo . " " . $nombre;

$var = filter_input(INPUT_POST, "codigo");
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

