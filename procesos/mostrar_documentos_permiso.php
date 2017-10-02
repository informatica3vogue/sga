<?php

@session_start();
include("../sql/class.managerDB.php");
include("../sql/class.data.php");
$data = new data();
$result = array();
$params=$_POST;

$sql2 = "SELECT documento FROM docu_permiso WHERE id_permiso = :id_permiso";
$param_list=array("id_permiso");
$result = $data->query($sql2, $params, $param_list);

echo json_encode($result);
?>