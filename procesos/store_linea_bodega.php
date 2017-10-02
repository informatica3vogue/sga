<?php

@session_start();
include("../sql/class.managerDB.php");
include("../sql/class.data.php");
$data = new data();
$array = array();

$params = $_GET;

$sql = "SELECT id_linea, linea FROM linea WHERE id_dependencia=:id_dependencia AND id_categoria =2 ORDER BY linea ASC";
$response = $data->query($sql, array("id_dependencia" => $_SESSION["id_dependencia"]));

echo json_encode($response);
?>