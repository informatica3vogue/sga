<?php

@session_start();
include("../sql/class.managerDB.php");
include("../sql/class.data.php");
$data = new data();
$array = array();

$params = $_GET;

$sql = "SELECT id_articulo, articulo, existencia FROM articulo WHERE id_categoria = 1 AND existencia > 0 AND id_dependencia=:id_dependencia ORDER BY articulo ASC";
$response = $data->query($sql, array("id_dependencia" =>  $_SESSION["id_dependencia"]));

echo json_encode($response);
?>