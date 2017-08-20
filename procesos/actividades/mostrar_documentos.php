<?php

@session_start();
include("../../sql/class.managerDB.php");
include("../../sql/class.data.php");
$data = new data();
$result = array();
$params=$_POST;

$sql2 = "SELECT documento FROM docu_actividad WHERE id_actividad = :id_actividad";
$param_list=array("id_actividad");
$result = $data->query($sql2, $params, $param_list);

echo json_encode($result);
?>