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
$sql = "INSERT INTO solicitud_articulo(fecha, observacion, estado, referencia, id_usuario)  VALUES (NOW(), :txtDetalle, 'Pendiente', :referencia, :id_usuario)";
$param_list = array("txtDetalle","referencia","id_usuario");
$response = $data->query($sql, $params, $param_list, true);

if($response['insertId'] != 0){
  foreach ($_SESSION['detalle_solicitud'] as $articulo) {
      $sql = "INSERT INTO detalle_solicitud(cantidad, id_articulo, id_solicitud_articulo) VALUES (:cantidad, :id_articulo, :id_solicitud_articulo)";
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
  $response=array('success'=>true, 'titulo'=>'Operación exitosa!', 'mensaje'=>'Se agrego solictud', 'tipo'=>'alert alert-success', 'id'=>$response['insertId']);
}

//si los datos se guardan limpiar la session y el formulario
unset($_SESSION['detalle_solicitud']);
echo json_encode($response);
?>