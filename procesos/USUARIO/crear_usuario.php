<?php
@session_start();
include("../../sql/class.data.php");
$data = new data();

$params = $_POST;
$params['usuario'] = (isset($params['usuario'])) ? $params['usuario'] : '';

$sql="SELECT usuario FROM usuario WHERE usuario = :usuario";
$param_validar_usuario = array("usuario");
$response_validar_usuario = $data->query($sql, $params, $param_validar_usuario);
if ($response_validar_usuario['total'] > 0) {
    $response = array('success'=>false, 'error'=>'Este nombre usuario ya esta en uso');
}else{
    $sql = "INSERT INTO usuario(usuario, contrasenia, estado, id_rol, id_empleado) VALUES(:usuario, md5('csj2016'), 'Activo', :id_rol, :id_empleado)";
    $param_list = array("usuario", "id_rol", "id_empleado");
    $response = $data->query($sql, $params, $param_list, true);
    if ($response['insertId'] > 0) {
        $response = array('success'=>true, 'mensaje'=>'Se realizo el ingreso de nuevo usuario');
    }else{
        $response = array('success'=>false, 'error'=>'Ocurrio un error al ejecutar la transacci&oacute;n');
    }
}

echo json_encode($response);
?>