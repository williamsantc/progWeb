<?php

class prueba extends QueryReflectPHP {

    private $id_prueba;
    private $nomb_prueba;
    private $camp_prueba;

    public function __set($property, $value) {
        if (property_exists($this, $property)) {
            $this->$property = $value;
        }
    }

    public function __get($property) {
        if (property_exists($this, $property)) {
            return $this->$property;
        }
    }

    public function propiedades() {
        return get_object_vars($this);
    }

    function Listar() {
        return parent::generarTablaHtml("SELECT * FROM prueba");
    }

    function Combo() {
        return parent::generarComboHTML("SELECT * FROM prueba");
    }

    function llenarFomularioHtml() {
        $script = "<script type=\"text/javascript\">\n$(document).ready(function () {\n";
        $prop = $this->propiedades();
        foreach ($prop as $key => $value) {
            if($value != "") {
                $script .= "document.getElementById('$key').value = \"$value\";\n";
            }
        }
        $script .= "});\n</script>";
        
        return $script;
    }
}