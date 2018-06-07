<?php

require './conect.php';
require './QueryReflectPHP.php';

$clave = filter_input(INPUT_GET, 'clave');
$valor = filter_input(INPUT_GET, 'valor');

$QR = new QueryReflectPHP();

echo json_encode($QR->buscarPrototype($clave, $valor));

