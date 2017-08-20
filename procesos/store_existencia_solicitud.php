<?php

@session_start();
include("../sql/class.managerDB.php");
include("../sql/class.data.php");
$data = new data();
$existencia = '';

$params = $_POST;

$sql = "SELECT existencia FROM articulo WHERE id_articulo = :id_articulo";
$results = $data->query($sql, array("id_articulo" => $params["id_articulo"]));
$existencia = (isset($results["items"][0]["existencia"])) ? $results["items"][0]["existencia"]: 0;

$result = $data->query('SELECT cantidad FROM detalle_solicitud WHERE id_solicitud_articulo = :id_solicitud_articulo AND id_articulo = :id_articulo', array("id_solicitud_articulo" => $params["id_solicitud_articulo"], "id_articulo" => $params["id_articulo"]));
$cantidad = (isset($result["items"][0]["cantidad"])) ? $result["items"][0]["cantidad"]: "";
$cantidad = ($cantidad > $existencia) ? "" : $cantidad;

$response = array('existencia' => $existencia, 'cantidad' => $cantidad);


echo json_encode($response);
?>