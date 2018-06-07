<?php

require './conect.php';

GenerarClases();

function GenerarClases() {

    $conexion = new conect();

    if ($rs1 = $conexion->getConnex()->query("show tables;")) {
        while ($fila1 = $rs1->fetch_assoc()) {
            //cambiar segun el esquema a generar clases
            $tabla = $fila1['Tables_in_' . $conexion->getDbname()];
            $file = fopen("../clases/$tabla.php", "w");
            $conte = "<?php\n\n" .
                    "class $tabla extends QueryReflectPHP {\n\n";
            $atributos = "";
            $rs2 = $conexion->getConnex()->query("SELECT * FROM $tabla;");
            while ($metadatos = mysqli_fetch_field($rs2)) {
                $atributos .= "    private $" . $metadatos->name . ";\n";
                
            }
            $reflect = "    public function __set(\$property, \$value) {
        if (property_exists(\$this, \$property)) {
            \$this->\$property = \$value;
        }
    }\n
    public function __get(\$property) {
        if (property_exists(\$this, \$property)) {
            return \$this->\$property;
        }
    }\n
    public function propiedades() {
        return get_object_vars(\$this);
    }\n
    function Listar() {
        return parent::generarTablaHtml(\"SELECT * FROM $tabla\");
    }\n
    function Combo() {
        return parent::generarComboHTML(\"SELECT * FROM $tabla\");
    }\n
    function llenarFomularioHtml() {\n" .
                    "        \$script = \"<script type=\\\"text/javascript\\\">\\n$(document).ready(function () {\\n\";\n" .
                    "        \$prop = \$this->propiedades();\n" .
                    "        foreach (\$prop as \$key => \$value) {\n" .
                    "            if(\$value != \"\") {\n" .
                    "                \$script .= \"document.getElementById('\$key').value = \\\"\$value\\\";\\n\";\n" .
                    "            }\n" .
                    "        }\n" .
                    "        \$script .= \"});\\n</script>\";\n" .
                    "        \n" .
                    "        return \$script;\n" .
                    "    }";
            $conte .= $atributos . "\n" . $reflect . "\n}";
            fwrite($file, $conte);
            fclose($file);
        }
    }
}
