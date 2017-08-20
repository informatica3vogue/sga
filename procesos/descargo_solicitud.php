<?php
ob_start();
@session_start();
include("../sql/class.managerDB.php");
include("../sql/class.data.php");


$data = new data();
$params = $_POST;
$params["id_dependencia"] = $_SESSION["id_dependencia"];
$params["txtUsuario"] = $_SESSION["id_usuario"];

$errors=array();
$sql = "INSERT INTO descargos(fecha, observacion, id_dependencia, id_usuario, id_solicitud_articulo)  VALUES (NOW(), :txtDetalle, :id_dependencia, :txtUsuario, :txtId)";
$param_list = array("txtDetalle", "id_dependencia", "txtUsuario", "txtId");
$response = $data->query($sql, $params, $param_list, true);

$params["id_descargos"]= $response['insertId'];
if($response['insertId'] != 0){
  foreach ($_SESSION['detalle_descargo'] as $articulo) {
      $params["cantidad"] = $articulo['cantidad'];
      $params["id_articulo"] = $articulo['id_articulo'];
      $sql = "INSERT INTO descargos_articulos (cantidad, id_articulo, id_descargos) VALUES (:cantidad, :id_articulo, :id_descargos)";
      $param_list = array("cantidad","id_articulo", "id_descargos");
      $result = $data->query($sql, $params, $param_list, true);
      if($result['insertId']>0){
        $sql = "UPDATE articulo SET existencia=(existencia-:cantidad) WHERE id_articulo=:id_articulo";
        $resultado = $data->query($sql, array('cantidad'=>$params["cantidad"], 'id_articulo'=>$params["id_articulo"]));

        $sql2="UPDATE solicitud_articulo SET estado='Finalizado', fecha_cancelacion=NOW() WHERE id_solicitud_articulo = :txtId";
        $param_list = array("txtId");
        $response2 = $data->query($sql2, $params, $param_list);

      }else{
        $errors['articulo'][]="No se agregó el articulo ".$articulo['articulo'];

      }
    }
}
if ($result["total"] < 1) {
   $response=array('success'=>false, 'titulo'=>'Verifique su información!', 'mensaje'=>'No se guardo el registro', 'tipo'=>'alert alert-danger');
}else{
  $response=array('success'=>true, 'titulo'=>'Operación exitosa!', 'mensaje'=>'Se relizo el descargo', 'tipo'=>'alert alert-success', 'errors'=>$errors, 'id'=>$params['txtId']);
 }

//si los datos se guardan limpiar la session y el formulario
unset($_SESSION['detalle_descargo']);
echo json_encode($response);
?>