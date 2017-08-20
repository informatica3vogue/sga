<?php
ob_start();
@session_start();
include("../sql/class.managerDB.php");
include("../sql/class.data.php");

$data = new data();
$params = $_POST;
$params["id_usuario"] = $_SESSION["id_usuario"];
$errors=array();
$sql = "INSERT INTO solicitud_articulo(fecha, observacion, id_usuario)  VALUES (NOW(), :txtDetalle, :id_usuario)";
$param_list = array("txtDetalle","id_usuario");
$response = $data->query($sql, $params, $param_list, true);

if($response['insertId'] != 0){
	foreach ($_SESSION['detalle_solicitud'] as $articulo) {
      $sql = "INSERT INTO detalle_solicitud (cantidad, id_articulo, id_solicitud_articulo) VALUES (:cantidad, :id_articulo, :id_solicitud_articulo)";
      $array = array("cantidad"=>$articulo['cantidad'], "id_articulo"=>$articulo['id_articulo'], "id_solicitud_articulo"=>$response['insertId']);
      $result = $data->query($sql, $array, array(), true);
      if($result['insertId']!=0){
      	$errors['articulo'][]="No se agregó el articulo ".$articulo['articulo'];
      }
    }
}
if ($response["total"] < 1) {
   $response=array('success'=>false, 'titulo'=>'Verifique su información!', 'mensaje'=>'No se guardo el registro', 'tipo'=>'alert alert-danger');
}else{
	$response=array('success'=>true, 'titulo'=>'Operación exitosa!', 'mensaje'=>'Se agrego solicitud', 'tipo'=>'alert alert-success', 'errors'=>$errors);
 }

//si los datos se guardan limpiar la session y el formulario
$_SESSION['detalle_solicitud']=array();
echo json_encode($response);
?>