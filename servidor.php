<?php

if(isset($_GET["cedula"])){
    
}
$cedula = filter_input(INPUT_GET, "cedula");
$nombre = filter_input(INPUT_GET, "nombre");

?>

<html>
    <head>
        
    </head>
    <body>
        <h1><?php echo $cedula .  " " . $nombre; ?></h1>
        <!-- hola !-->
    </body>
</html>