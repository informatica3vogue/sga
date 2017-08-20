<?php

@session_start();
include("../sql/class.managerDB.php");
include("../sql/class.data.php");
$data = new data();

$params = $_GET;
$sql = "SELECT id_dependencia, dependencia FROM bddependencias.dependencia ORDER BY dependencia ASC";
$response = $data->query($sql);

echo json_encode($response);
?>