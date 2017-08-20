<?php
@session_start();
include("../../sql/class.data.php");

$params=$_POST;
$data= new data();
$sql="UPDATE usuario SET estado=:txtEstado WHERE id_usuario=:txtId2";
$param_list=array("txtEstado", "txtId2");
$response=$data->query($sql, $params, $param_list,true);
if ($response["success"] == false) {
   $response=array('success'=>false, 'titulo'=>'Verifique su información!', 'mensaje'=>'No se puede cambiar el estado', 'tipo'=>'alert alert-danger');
}else{
	$response=array('success'=>true, 'titulo'=>'Operación exitosa!', 'mensaje'=>'Estado modificado', 'tipo'=>'alert alert-success');
}
echo json_encode($response);
?>