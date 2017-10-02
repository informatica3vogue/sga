<?php

@session_start();

include("../../sql/class.data.php");
$data = new data();

$params=$_POST;

$sql = "SELECT documento FROM docu_seguimiento WHERE id_seguimiento = :id_seguimiento";
$param_list=array("id_seguimiento");
$response = $data->query($sql, $params, $param_list);

echo json_encode($response);
?>