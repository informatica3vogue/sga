<?php

class connDB {

    // declaracion de variables para conexion mysql
    var $DB_MySQL;
    var $Server_MySQL;
    var $User_MySQL;
    var $Password_MySQL;
    // declaracion de variables para conexion access
    var $DB_Access;
    var $Server_Access;
    var $User_Access;
    var $Password_Access;

    function connDB() {
        // parametros para conexion a base de datos de mysql
        $this->DB_MySQL = "control_actividades";
        $this->Server_MySQL = "localhost";
        $this->User_MySQL = "root";
        $this->Password_MySQL = "adminadmin";
        // parametros para conexion a base de datos de access
        $this->DB_Access = 'C:\xampp\htdocs\bd_activo_fijo\Activo Fijo.mdb';
        $this->Server_Access = "{Microsoft Access Driver (*.mdb)}";
        $this->User_Access = "";
        $this->Password_Access = "";

    }
}
?>