<?php

class QueryReflectPHP {

    function RegistrarMySQL($object, $conexion = null) {
        $conectNull = false;

        if($conexion == null) {
            $conectNull = true;
            $conexion = new conect();
        }

        if ($this->CheckNull($object, $conexion)) {
            return "Campos incompletos";
        }

        $reflect = new ReflectionClass($object);
        $param = "";
        $values = "";
        $cont = 0;
        $sql_primarias = "SELECT COLUMN_NAME FROM information_schema.COLUMNS where TABLE_NAME = '"
                . $reflect->getName() . "' AND TABLE_SCHEMA = '"
                . $conexion->getDbname() . "' AND COLUMN_KEY = 'UNI'";

        $rs = $conexion->getConnex()->query($sql_primarias);
        $Validate = "SELECT * FROM " . $reflect->getName() . " where ";
        $WhereDef_Clause = "";
        $cont = 0;
        while ($row = $rs->fetch_assoc()) {
            if ($cont > 0) {
                $WhereDef_Clause .= " AND";
            }
            foreach ($row as $key => $value) {
                $WhereDef_Clause .= " $value = '" . $object->$value . "'";
            }
            $cont++;
        }
        $Validate .= $WhereDef_Clause;
        if ($this->SQLvalidar($Validate)) {
            return "La informacion introducida ya existe, intente nuevamente";
        }
        $cont = 0;
        $props = $reflect->getProperties(ReflectionProperty::IS_PRIVATE);
        foreach ($props as $prop) {
            $prop->setAccessible(true);
            $propValue = $prop->getValue($object);
            if (!is_object($propValue)) {
                if ($cont > 1) {
                    $param .= ", ";
                    $values .= ", ";
                } else if ($cont == 0) {
                    $cont++;
                    continue;
                }
                $param .= $prop->getName();

                if (strlen($propValue) > 0) {
                    $values .= "'" . $propValue . "'";
                } else {
                    $values .= "null";
                }
                $cont++;
            }
        }
        $sql = "INSERT INTO " . $reflect->getName() . " (" . $param . ") VALUES (" . $values . ");";

        try {

            if ($conexion->getConnex()->query($sql) === TRUE) {
                return "Registro existoso";
            } else {
                return $sql . ' ' . $conexion->getConnex()->error . ' ' . "Error al registrar";
            }
        } catch (Exception $exc) {
            return $exc->getTraceAsString();
        } finally {
            if($conectNull){
                $conexion->desconectar();
            }
            
        }
    }

    function ModificarMySQL($object, $conexion = null, $where = [], $null = false) {

        $conectNull = false;

        if($conexion == null) {
            $conectNull = true;
            $conexion = new conect();
        }

        if ($this->CheckNull($object, $conexion)) {
            return "Campos incompletos";
        }

        $reflect = new ReflectionClass($object);
        $props = $reflect->getProperties(ReflectionProperty::IS_PRIVATE);
        if (count($where) == 0) {
            $PrimaryKeys = "SELECT COLUMN_NAME FROM information_schema.COLUMNS where TABLE_NAME = '"
                    . $reflect->getName() . "' AND TABLE_SCHEMA = '"
                    . $conexion->getDbname() . "' AND COLUMN_KEY = 'UNI'";

            $rs = $conexion->getConnex()->query($PrimaryKeys);
            $Validate = "SELECT * FROM " . $reflect->getName() . " where ";
            $WhereDef_Clause = "";
            $cont = 0;
            while ($row = $rs->fetch_assoc()) {
                if ($cont > 0) {
                    $WhereDef_Clause .= " AND";
                }
                foreach ($row as $key => $value) {
                    $WhereDef_Clause .= " $value = '" . $object->$value . "'";
                }
                $cont++;
            }
            $Validate .= $WhereDef_Clause;
            if (!$this->SQLvalidar($Validate)) {
                return "No se puede modificar, llaves unicas no registradas";
            }
        }
        $update = "UPDATE " . $reflect->getName() . " SET ";
        $cont = 0;
        foreach ($props as $prop) {
            $prop->setAccessible(true);
            $propValue = $prop->getValue($object);
            if (!is_object($propValue) && (strlen($propValue) > 0 || (strlen($propValue) == 0 && $null))) {
                if ($cont > 0) {
                    $update .= ", ";
                }
                $update .= $prop->getName();
                if (strlen($propValue) > 0) {
                    $update .= " = '" . $propValue . "'";
                } else if (strlen($propValue) == 0 && $nulos) {
                    $update .= " = null";
                }
                $cont++;
            }
        }
        $cont = 0;
        if (count($where) > 0) {
            $custom_where = "";
            foreach ($where as $key => $value) {
                if ($cont > 0) {
                    $custom_where .= " AND";
                }
                $custom_where .= " $key = '$value'";
            }
            $update .= " WHERE " . $custom_where;
        } else {
            $update .= " WHERE " . $WhereDef_Clause;
        }

        $conexion = new conect();

        try {
            if ($conexion->getConnex()->query($update) === TRUE) {
                return "Modificacion exitosa";
            } else {
                echo '<script>console.log("' . $update . $conexion->getConnex()->error . '")</script>';

                return "Error al modificar, intentelo mas tarde";
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        } finally {
            if($conectNull){
                $conexion->desconectar();
            }
        }
    }

    function BuscarMySQL($object) {
        $conexion = new conect();
        $reflect = new ReflectionClass($object);
        $Validate = "SELECT * FROM " . $reflect->getName() . " where ";
        $props = $reflect->getProperties(ReflectionProperty::IS_PRIVATE);
        foreach ($props as $prop) {
            $prop->setAccessible(true);
            $propValue = $prop->getValue($object);
            if (!is_object($propValue) && strlen($propValue) > 0) {

                if ($cont > 0) {
                    $values .= " AND";
                }
                $values .= $prop->getName() . " = '" . $propValue . "'";

                $cont++;
            }
        }

        $Validate .= $values;
        $fila = $this->SQLListar($Validate);
        if (count($fila) <= 0) {
            return null;
        }

        foreach ($fila[0] as $key => $value) {
            $object->$key = $value;
        }
        return $object;
    }

    function BuscarMySQLByUNIQUE($object) {

        $conexion = new conect();
        $reflect = new ReflectionClass($object);
        $cont = 0;
        $sql_primarias = "SELECT COLUMN_NAME FROM information_schema.COLUMNS where TABLE_NAME = '"
                . $reflect->getName() . "' AND TABLE_SCHEMA = '"
                . $conexion->getDbname() . "' AND COLUMN_KEY = 'UNI'";
        $rs = $conexion->getConnex()->query($sql_primarias);
        $Validate = "SELECT * FROM " . $reflect->getName() . " where ";
        $WhereDef_Clause = "";
        $cont = 0;
        while ($row = $rs->fetch_assoc()) {
            if ($cont > 0) {
                $WhereDef_Clause .= " OR";
            }
            foreach ($row as $key => $value) {
                $WhereDef_Clause .= " $value = '" . $object->$value . "'";
            }
            $cont++;
        }
        $Validate .= $WhereDef_Clause;

        $fila = $this->SQLListar($Validate);
        if (count($fila) <= 0) {
            return null;
        }

        foreach ($fila[0] as $key => $value) {
            $object->$key = $value;
        }
        return $object;
    }

    function CheckNull($object, $conexion = null) {
        if($conexion == null) {
            $conexion = new conect();
        }

        $reflect = new ReflectionClass($object);

        $props = $reflect->getProperties(ReflectionProperty::IS_PRIVATE);

        $primaria = $this->SQLUndato("SELECT COLUMN_NAME FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = '" . $conexion->getDbname()
                . "' AND TABLE_NAME = '" . $reflect->getName() . "' AND COLUMN_KEY = 'PRI' AND EXTRA = 'auto_increment'");

        $mandatoryFields = "SELECT COLUMN_NAME FROM information_schema.COLUMNS where TABLE_NAME = '" . $reflect->getName()
                . "' AND TABLE_SCHEMA = '" . $conexion->getDbname()
                . "' AND IS_NULLABLE = 'NO' AND COLUMN_NAME <> '$primaria'";
        $rs = $conexion->getConnex()->query($mandatoryFields);
        while ($row = $rs->fetch_assoc()) {
            foreach ($row as $key => $value) {
                if (strlen($object->$value) <= 0) {
                    return true;
                }
            }
        }

        return false;
    }

    function buscarPrototype($calve, $valor) {

        $conexion = new conect();

        //Obtiene el nombre de la tabla a la que pertenece la clave (nombre del campo)
        $sql = "SELECT TABLE_NAME FROM information_schema.COLUMNS "
                . "WHERE COLUMN_NAME = '$calve' AND TABLE_SCHEMA = '" . $conexion->getDbname() . "';";

        $tabla = $this->SQLUndato($sql);

        if (!$this->SQLvalidar("SELECT * FROM $tabla WHERE $calve = '$valor' LIMIT 1;")) {
            return array("error" => "Informacion no encontrada");
        }

        $fila = $this->SQLListar("SELECT * FROM $tabla WHERE $calve = '$valor' LIMIT 1;");

        $primaria = $this->SQLUndato("SELECT COLUMN_NAME FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = '"
                . $conexion->getDbname()
                . "' AND TABLE_NAME = '$tabla' AND COLUMN_KEY = 'PRI' AND EXTRA = 'auto_increment'");

        
        $normalizadas = $this->SQLListar("SELECT TABLE_NAME, COLUMN_NAME FROM information_schema.KEY_COLUMN_USAGE WHERE `TABLE_SCHEMA` = '"
                . $conexion->getDbname() . "' AND`REFERENCED_TABLE_NAME` = '$tabla' AND `REFERENCED_COLUMN_NAME` = '$primaria' AND TABLE_NAME LIKE '$tabla%'");

        //Aqui se supone que va un pinche for (donde va cero itera para cada posible tabla normalizada)

        if (count($normalizadas) == 0 || !$this->SQLvalidar("SELECT * FROM " . $normalizadas[0]['TABLE_NAME'] . " WHERE $primaria = '" . $fila[0][$primaria] . "'")) {
            return array("DATA" => $fila[0], "NOMAL" => "");
        }
        $contNormalizada = $this->SQLListar("SELECT * FROM " . $normalizadas[0]['TABLE_NAME'] . " WHERE $primaria = '" . $fila[0][$primaria] . "'");


        $TablaForanea = $this->SQLListar("SELECT `REFERENCED_TABLE_NAME` as tab, `REFERENCED_COLUMN_NAME` as col "
                . "FROM information_schema.KEY_COLUMN_USAGE WHERE `TABLE_NAME` = '"
                . $normalizadas[0]['TABLE_NAME'] . "' AND `TABLE_SCHEMA` = '" . $conexion->getDbname()
                . "' AND `COLUMN_NAME` <> '" . $normalizadas[0]['COLUMN_NAME'] . "' AND `REFERENCED_TABLE_NAME` <> 'NULL'");

        $normRT = array();
        for ($i = 0; $i < count($contNormalizada); $i++) {
            $claveJSON = $contNormalizada[$i][$TablaForanea[0]["col"]] . $TablaForanea[0]["tab"];
            $normRT[$claveJSON] = $contNormalizada[$i][$TablaForanea[0]["col"]];
        }

        $JSON = array("DATA" => $fila[0], "NOMAL" => $normRT);

        return $JSON;
    }

    function SQLUpdate_Delete($sql) {

        $conexion = new conect();
        try {
            if ($conexion->getConnex()->query($sql)) {
                return "Operacion exitosa";
            } else {
                return "Ocurrio un error";
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        } finally {
            $conexion->desconectar();
        }
    }

    function SQLListar($sql) {

        $conexion = new conect();

        try {
            $array = [];
            $rs = $conexion->getConnex()->query($sql);
            $cont = 0;
            while ($fila = $rs->fetch_assoc()) {
                $array[$cont] = $fila;
                $cont++;
            }

            return $array;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        } finally {
            $conexion->desconectar();
        }
    }

    function SQLvalidar($consulta) {

        $conexion = new conect();
        try {
            if ($rs = $conexion->getConnex()->query($consulta)) {
                while ($fila = $rs->fetch_assoc()) {
                    return true;
                }
            }

            return false;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        } finally {
            $conexion->desconectar();
        }
    }

    function SQLUndato($consulta) {

        $conexion = new conect();
        try {
            if ($rs = $conexion->getConnex()->query($consulta)) {
                while ($fila = $rs->fetch_assoc()) {
                    foreach ($fila as $key => $value) {
                        return $value;
                    }
                }
            }
            return 0;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        } finally {
            $conexion->desconectar();
        }
    }

    function obtenerIdmax($consulta) {

        $conexion = new conect();
        try {
            $cont = 0;
            if ($rs = $conexion->getConnex()->query($consulta)) {
                while ($fila = $rs->fetch_assoc()) {
                    foreach ($fila as $key => $value) {
                        if ($cont === 0) {

                            return $value + 1;
                        } else {
                            break;
                        }
                        $cont++;
                    }
                }
            }
            return 1;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        } finally {
            $conexion->desconectar();
        }
    }

    function generarTablaHtml($sql) {

        $conexion = new conect();
        try {
            $t_head = '<thead class=" text-primary">'
                    . '<tr>';
            $saber = true;
            $t_body = ' <tbody>';
            $rs = $conexion->getConnex()->query($sql);
            while ($fila = $rs->fetch_assoc()) {

                $t_body .= '<tr>';
                if (count($fila) <= 0) {
                    return "";
                }

                foreach ($fila as $key => $value) {
                    if ($saber) {
                        $t_head .= '<th>' . $key . '</th>';
                    }
                    $t_body .= '<td>' . $value . '</td>';
                }
                $t_body .= '</tr>';
                if ($saber) {
                    $t_head = $t_head . '</tr> </thead>';
                }
                $saber = false;
            }
            $t_body .= '</tbody>';

            $tabla = '<table id="tableData" class="table table-striped" content="text/html; charset=iso-8859-1">' . $t_head . $t_body . '</table>';
            return $tabla;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        } finally {
            $conexion->desconectar();
        }
    }

    function generarComboHTML($sql, $Firstop = "", $obligatorio = true, $disabled = false, $onchange = "") {
        $conexion = new conect();
        if ($Firstop !== "") {
            $Firstop = '<option value="null">' . $Firstop . '</option>';
        }
        if ($disabled === true) {
            $disabled = 'disabled="true"';
        } else {
            $disabled = '';
        }
        if ($obligatorio == true) {
            $obligatorio = "m129f03d0";
        } else {
            $obligatorio = "";
        }
        if ($onchange !== "") {
            $onchange = ' onchange="' . $onchange . '" ';
        }
        try {
            $id = '';
            $contenido = [0 => '', 1 => ''];
            $select = '';

            $rs = $conexion->getConnex()->query($sql);
            while ($fila = $rs->fetch_assoc()) {
                $cont = 0;
                foreach ($fila as $key => $value) {
                    if ($cont == 0) {
                        $id = $key;
                    }
                    $contenido[$cont] = $value;
                    $cont++;
                    if ($cont > 1) {
                        break;
                    }
                }
                $select .= '<option value="' . $contenido[0] . '">' . $contenido[1] . '</option>';
            }
            $select = '<select class="form-control ' . $obligatorio . '" id="' . $id . '" name="' . $id . '" ' . $onchange . $disabled . '>' . $Firstop . ' ' . $select . '</select>';
            return $select;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        } finally {
            $conexion->desconectar();
        }
    }

    /*
      Para que este metodo funcione requiere que los campos lleven un alias clave -> valor

      EJEMPLO: SELECT usua_id as clave, usua_nom as valor FROM usuario
     */

    function generarCheckboxHTML($sql, $limite = 5) {
        $control = $limite;
        $return = "<div class='row'>";
        $columna = "<div class='col-md-6'>";
        $lista = $this->SQLListar($sql);
        if (count($lista) > 0) {
            foreach ($lista as $key => $value) {

                $columna .= "<div class='form-group form-check' style='margin-top: 7px;'>
                                                        <label class='form-check-label'>
                                                            
                                                            <input class='form-check-input' type='checkbox' name='" . $value['clave'] . get_class($this) . "' id='" . $value['clave'] . get_class($this) . "' value='" . $value['clave'] . "'>
                                                            " . $value['valor'] . "
                                                            <span class='form-check-sign'></span>
                                                        </label>
                                                    </div>";
                if ($key == $control - 1) {
                    $columna .= "</div>";
                    $return .= $columna;
                    $columna = "<div class='col-md-4'>";
                    $control += $limite;
                }
            }
            $columna .= "</div>";
            $return .= $columna;
            $return .= "</div>";
            return $return;
        } else {
            return "<div align='center'><h3> NO HAY ENVIOS DISPONIBLES </h3></div>";
        }
    }

}
