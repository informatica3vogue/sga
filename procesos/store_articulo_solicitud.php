<?php

@session_start();
include("../sql/class.managerDB.php");
include("../sql/class.data.php");
$data = new data();
$params = $_POST;
$sql = "SELECT a.id_articulo, a.articulo FROM solicitud_articulo sa INNER JOIN detalle_solicitud ds ON sa.id_solicitud_articulo = ds.id_solicitud_articulo INNER JOIN articulo a ON ds.id_articulo = a.id_articulo WHERE ds.id_solicitud_articulo = :id_solicitud_articulo";
$param_list=array("id_solicitud_articulo");
$response = $data->query($sql, $params, $param_list);
echo json_encode($response);
?>