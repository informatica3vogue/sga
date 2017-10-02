<?php
include("../../sql/class.data.php");
$data = new data();
$params = $_POST;

$sql = "SELECT grupo FROM grupo WHERE id_grupo=:id";
$param_list=array("id");
$response = $data->query($sql, $params, $param_list);


echo json_encode($response);
?>