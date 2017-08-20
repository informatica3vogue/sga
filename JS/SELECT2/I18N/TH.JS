<?php
ob_start();
@session_start();
include("../sql/class.managerDB.php");
include("../sql/class.data.php");
include("../php/generar_referencia.php");
$data = new data();
$params = $_POST;
$params["id_usuario"] = $_SESSION["id_usuario"];
$params["referencia"] = generar_referencia_soli();
$errors=array();
$sql = "INSERT INTO solicitud_articulo(fecha, observacion, referencia, id_usuario)  VALUES (NOW(), :txtDetalle, :referencia, :id_usuario)";
$param_list = array("txtDetalle","referencia","id_usuario");
$response = $data->query($sql, $params, $param_list, true);

if($response['insertId'] != 0){
	foreach ($_SESSION['detalle_solicitud'] as $articulo) {
      $sql = "INSERT INTO detalle_solicitud (cantidad, id_articulo, id_solicitud_articulo) VALUES (:cantidad, :id_articulo, :id_solicitud_articulo)";
      $array = array("cantidad"=>$articulo['cantidad'], "id_articulo"=>$articulo['id_articulo'], "id_solicitud_articulo"=>$re