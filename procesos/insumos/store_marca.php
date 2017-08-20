<?php
@session_start();

include("../../sql/class.data.php");
$data = new data();

$array = array();
$params = $_GET;
$sql = "SELECT id_marca, marca FROM marca WHERE id_dependencia = :id_dependencia AND id_categoria = 1 ORDER BY marca ASC";
$response = $data->query($sql, array("id_dependencia" => $_SESSION["id_dependencia"]));

echo json_encode($response);
?>