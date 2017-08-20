<?php
@session_start();
include("../sql/class.managerDB.php");
include("../sql/class.data.php");

$params=$_POST;
$data= new data();
$sql="DELETE FROM seccion WHERE id_seccion=:txtId3";
$param_list=array("txtId3");
$response=$data->query($sql, $params, $param_list);
if ($response["success"] == true) {
	$response=array('success'=>true, 'titulo'=>'Operación exitosa!', 'mensaje'=>'Sección eliminada', 'tipo'=>'alert alert-success');
}else{
    $response=array('success'=>false, 'titulo'=>'Verifique su información!', 'mensaje'=>'No se puede eliminar la sección', 'tipo'=>'alert alert-danger');
}
echo json_encode($response);
?>