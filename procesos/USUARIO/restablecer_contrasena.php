<?php
@session_start();
include("../../sql/class.data.php");

$data= new data();

$params=$_POST;
$params["reset"] = md5("csj2016");
$sql = "UPDATE usuario SET contrasenia = :reset WHERE id_usuario=:id";
$param_list = array("reset", "id");
$response = $data->query($sql, $params, $param_list, true);
if ($response["success"] == true) {
    $response=array('success'=>true, 'titulo'=>'Operaci&oacute;n exitosa!', 'msg'=>'Contrase&ntilde;a reestablecida');
}else{
    $response=array('success'=>false, 'titulo'=>'Verifique su informaci&oacute;n!', 'msg'=>'No se pudo reestablecer contrase&ntilde;a');
}
echo json_encode($response);
?>