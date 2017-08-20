<?php

include_once ("class.connDB.php");

#Esta clase nos permitira conectarnos a la base de datos
class managerDB {
    
    #Constructor
    function managerDB() {       
    }

    function conectar($tipo) {
        $conectar = new connDB();
        try {
            if ($tipo == "mysql") {
                $connection = new PDO("mysql:host=$conectar->Server_MySQL;dbname=$conectar->DB_MySQL;charset=UTF8", "$conectar->User_MySQL", "$conectar->Password_MySQL");
            }else if ($tipo == "access") {
                $connection = new PDO("odbc:DRIVER=$conectar->Server_Access;DBQ=$conectar->DB_Access;Uid=$conectar->User_Access;Pwd=$conectar->Password_Access");
            }
        } catch (PDOException $e) {
            //echo $e->getMessage();
            $connection = null;
        }
        return($connection);
    }
}
?>