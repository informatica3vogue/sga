<?php

@session_start();
include("../sql/class.managerDB.php");
include("../sql/class.data.php");
$data = new data();

$params = $_GET;

$sql = "SELECT id_unidad, unidad_medida FROM unidad WHERE id_dependencia = :id_dependencia AND id_categoria = 2 ORDER BY unidad_medida ASC";
$response = $data->query($sql, array("id_dependencia" => $_SESSION["id_dependencia"]));

echo json_encode($response);
?>