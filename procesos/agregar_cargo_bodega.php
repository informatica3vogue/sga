<?php

@session_start();
include("../sql/class.managerDB.php");
include("../sql/class.data.php");

$data = new data();

$params = $_POST;
$params["id_usuario"] = $_SESSION["id_usuario"];
$params["id_dependencia"] = $_SESSION["id_dependencia"];

$cargo= $_POST['txtCantidad'];
$sql = "INSERT INTO cargo_bodega(fecha, cantidad, referencia, observacion, id_dependencia, id_usuario, id_articulo)  VALUES (NOW(), :txtCantidad, :txtReferecia, :txObservacion, :id_dependencia, :id_usuario, :txtArticulo)";
$param_list = array("txtCantidad", "txtReferecia","txObservacion", "id_dependencia", "id_usuario", "txtArticulo");
$response = $data->query($sql, $params, $param_list, true);

if ($response["insertId"] <> 0) {
 	$sql = "UPDATE articulo SET existencia = (existencia + :txtCantidad)  WHERE id_articulo = :txtArticulo";
    $param_list = array("txtArticulo", "txtCantidad");
    $result = $data->query($sql, $params, $param_list);
}

if ($response["total"] > 0) {
	$response=array('success'=>true, 'titulo'=>'Operación exitosa!', 'mensaje'=>'Se cargo el artículo');
}else{
   	$response=array('success'=>false, 'titulo'=>'Verifique su información!', 'mensaje'=>'No se guardo el registro');
}
echo json_encode($response);
?>