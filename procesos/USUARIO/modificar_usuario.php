<?php
@session_start();
include("../../sql/class.data.php");

$params=$_POST;
$data= new data();

$sql = "UPDATE empleado SET nombre = :nombres, apellido = :apellidos, cargo = :cargo  WHERE id_empleado = :id_empleado";
$param_list = array("nombres", "apellidos", "cargo", "id_empleado");
$response = $data->query($sql, $params, $param_list, true);

if ($params['id_usuario'] != '' AND $params['acceso'] == 'Si') {
    $sql = "UPDATE usuario SET id_rol = :id_rol, usuario = :usuario, estado = 'Activo' WHERE id_usuario = :id_usuario";
    $param_list = array("id_rol", "usuario", "id_usuario");
    $response = $data->query($sql, $params, $param_list, true);
}elseif ($params['id_usuario'] != '' AND $params['acceso'] == 'No') {
    $sql="UPDATE usuario SET estado='Inactivo' WHERE id_usuario=:id_usuario";
    $param_list=array("id_usuario");
    $response=$data->query($sql, $params, $param_list,true);
}elseif ($params['id_usuario'] == '' AND $params['acceso'] == 'Si') {
    $sql = "INSERT INTO usuario(usuario, contrasenia, estado, id_rol, id_empleado) VALUES(:usuario, md5('csj2016'), 'Activo', :id_rol, :id_empleado)";
    $param_list = array("usuario", "id_rol", "id_empleado");
    $response = $data->query($sql, $params, $param_list, true);
}

if ($params['id_seccion_antigua'] != $params['id_seccion']) {
    $sql = "UPDATE empleado_seccion SET id_seccion = :id_seccion  WHERE id_empleado = :id_empleado AND id_seccion = :id_seccion_antigua AND estado = 'Activo'";
    $param_list = array("id_empleado", "id_seccion", "id_seccion_antigua");
    $response = $data->query($sql, $params, $param_list, true);
}

if ($response['total'] > 0 OR $response['success'] == true) {
    $response = array("success"=>true, 'titulo'=>'Operacion exitosa!', 'mensaje'=>'Se modifico el empleado');
} else {
    $response = array('success'=>false, 'titulo'=>'Verifique su informacion!', 'error'=>'No se realizo ningun cambio');
}
echo json_encode($response);
?>