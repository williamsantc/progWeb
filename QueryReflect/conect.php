<?php

class conect {

    private $servername = "localhost";
    private $username = "root";
    private $password = "";
    private $dbname = "progweb";
    private $connex;
    
    public function conect() {
        $this->connex = mysqli_connect($this->servername, $this->username, $this->password, $this->dbname, 3307) or die('error en conexion');
        mysqli_set_charset($this->connex,"utf8");
    }

    function desconectar() {
        $this->connex->close();
    }

    function getServername() {
        return $this->servername;
    }

    function getUsername() {
        return $this->username;
    }

    function getPassword() {
        return $this->password;
    }

    function getDbname() {
        return $this->dbname;
    }

    function getConnex() {
        return $this->connex;
    }

    function setServername($servername) {
        $this->servername = $servername;
    }

    function setUsername($username) {
        $this->username = $username;
    }

    function setPassword($password) {
        $this->password = $password;
    }

    function setDbname($dbname) {
        $this->dbname = $dbname;
    }

    function setConnex($connex) {
        $this->connex = $connex;
    }

}



