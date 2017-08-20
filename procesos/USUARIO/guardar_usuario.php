<?php
@session_start();
include("../../sql/class.data.php");
$data = new data();

$params = $_POST;
$params['usuario'] = (isset($params['usuario'])) ? $params['usuario'] : '';

$sql="SELECT * FROM empleado INNER JOIN empleado_seccion ON empleado.id_empleado=empleado_seccion.id_empleado INNER JOIN seccion ON seccion.id_seccion=empleado_seccion.id_seccion WHERE nombre = :nombres AND apellido = :apellidos AND id_dependencia = :id_dependencia";
$param_validar_empleado = array("nombres", "apellidos", "id_dependencia");
$response_validar_empleado = $data->query($sql, $params, $param_validar_empleado);

if ($response_validar_empleado['total'] > 0) {
    $response = array('success'=>false, 'error'=>'Este empleado ya fue ingresado');  
}else{
    $sql="SELECT usuario FROM usuario WHERE usuario = :usuario";
    $param_validar_usuario = array("usuario");
    $response_validar_usuario = $data->query($sql, $params, $param_validar_usuario);
    if ($response_validar_usuario['total'] > 0) {
        $response = array('success'=>false, 'error'=>'Este nombre usuario ya esta en uso');
    }else{
        $sql = "INSERT INTO empleado(nombre, apellido, cargo) VALUES(:nombres, :apellidos, :cargo)";
        $param_empleado = array("nombres", "apellidos", "cargo");
        $response_empleado = $data->query($sql, $params, $param_empleado, true);
        if ($response_empleado['insertId'] > 0) {
            $params['id_empleado'] = $response_empleado['insertId'];
            $sql = "INSERT INTO empleado_seccion(estado, fecha_procesamiento, id_empleado, id_seccion) VALUES('Activo', NOW(), :id_empleado, :id_seccion)";
            $param_list = array("id_empleado", "id_seccion");
            $response = $data->query($sql, $params, $param_list, true);
            if ($response['insertId'] > 0) {
                $response = array('success'=>true, 'mensaje'=>'Se realizo el ingreso de nuevo empleado');
                if ($params['acceso'] == 'Si') {
                    $sql = "INSERT INTO usuario(usuario, contrasenia, estado, id_rol, id_empleado) VALUES(:usuario, md5('csj2016'), 'Activo', :id_rol, :id_empleado)";
                    $param_list = array("usuario", "id_rol", "id_empleado");
                    $response = $data->query($sql, $params, $param_list, true);
                    if ($response['insertId'] > 0) {
                        $response = array('success'=>true, 'mensaje'=>'Se realizo el ingreso de nuevo usuario');
                    }
                }  
            }
        }else{
            $response = array('success'=>false, 'error'=>'Ocurrio un error al realizar el ingreso');  
        }
    }
}

echo json_encode($response);
?>