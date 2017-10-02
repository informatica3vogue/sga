<?php

@session_start();
include("../sql/class.managerDB.php");
include("../sql/class.data.php");
$data = new data();
$existencia = '';

$params = $_POST;
if ($params["id_articulo"] != "" || $params["id_articulo"] != null) {
	$sql = "SELECT existencia FROM articulo WHERE id_articulo = :id_articulo";
	$response = $data->query($sql, array("id_articulo" => $params["id_articulo"]));
	$existencia = (isset($response["items"][0]["existencia"])) ? $response["items"][0]["existencia"]: 0;
}
echo json_encode($existencia);
?>