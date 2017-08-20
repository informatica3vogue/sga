<?php
@session_start();
include("../sql/class.managerDB.php");
include("../sql/class.data.php");
$data= new data();

$params=$_POST;

$sql="UPDATE empleado_seccion SET estado=:txtEstado, observacion=:txtDescripcion, fecha_final=NOW() WHERE id_empleado=:txtId";
$param_list=array("txtEstado","txtDescripcion", "txtId");
$response=$data->query($sql, $params, $param_list);

if ($response["total"] > 0) {
	$response=array('success'=>true, 'titulo'=>'Operación exitosa!', 'mensaje'=>'Estado modificado');
}else{
    $response=array('success'=>false, 'titulo'=>'Verifique su información!', 'mensaje'=>'No se puede cambiar el estado');
}
echo json_encode($response);
?>