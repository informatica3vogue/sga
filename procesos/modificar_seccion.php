<?php
@session_start();
include("../sql/class.managerDB.php");
include("../sql/class.data.php");

$params=$_POST;
$data= new data();
$sql="UPDATE seccion SET seccion = :txtSeccionActual WHERE id_seccion = :txtId4";
$param_list=array("txtSeccionActual","txtId4");
$response=$data->query($sql, $params, $param_list);
if ($response["success"] == true) {
	$response=array('success'=>true, 'titulo'=>'Operación exitosa!', 'mensaje'=>'Sección modificada', 'tipo'=>'alert alert-success');
}else{
    $response=array('success'=>false, 'titulo'=>'Verifique su información!', 'mensaje'=>'No se puede modificar la sección', 'tipo'=>'alert alert-danger');
}
echo json_encode($response);
?>