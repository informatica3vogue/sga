<?php
@session_start();

include("../../sql/class.managerDB.php");
include("../../sql/class.data.php");
$data= new data();

$params = $_POST;
$params["id_usuario"] = $_SESSION["id_usuario"];
$error_docs = "";

$sql="UPDATE repositorio SET tipo_repositorio=:txtTipo WHERE id_repositorio=:txtId";
$param_list = array("txtTipo","txtId");
$response = $data->query($sql, $params, $param_list, true);

if ($params["txtTipo"] == 1) {
    $sql="UPDATE usuario_repositorio SET estado='Inactivo' WHERE id_repositorio=:txtId AND id_usuario <> :id_usuario";
    $param_list = array("id_usuario","txtId");
    $response = $data->query($sql, $params, $param_list, true);

    if ($response["success"] == true) {
        $response=array('success'=>true, 'titulo'=>'Operación exitosa!', 'mensaje'=>'El repositorio ha pasado a ser privado');
    }else{
        $response=array('success'=>false, 'titulo'=>'Verifique su información!', 'mensaje'=>'No se realizo ningun cambio');
    }
}else{

    $sql_usuarios = "SELECT id_usuario FROM usuario_repositorio WHERE id_repositorio = :txtId";
    $param_list = array("txtId");
    $response_usuarios = $data->query($sql_usuarios, $params, $param_list);

    foreach ($response_usuarios['items'] as $consulta_usuarios) {
        $encontrado = false;
        $id_usuario = 0;
        foreach ($params['txtPara'] as $id) {
            if ($consulta_usuarios['id_usuario'] == $id) {
                $encontrado = true;
                $id_usuario = $id;
            }
        }
        if ($encontrado == false) {
            $sql_update = "UPDATE usuario_repositorio SET estado='Inactivo' WHERE id_repositorio = :id_repositorio AND id_usuario = :id_usuario AND id_usuario <> :id_usuario_propietario";
            $params_update = array("id_repositorio"=>$params["txtId"], "id_usuario"=>$consulta_usuarios['id_usuario'],"id_usuario_propietario"=>$params["id_usuario"]);
            $response_update = $data->query($sql_update, $params_update, array(), true);
            if ($response['success'] == true) {
                $response=array('success'=>true, 'titulo'=>'Operación exitosa!', 'mensaje'=>'El repositorio ha sido compartido');
            }else{
                $response=array('success'=>false, 'titulo'=>'Verifique su información!', 'mensaje'=>'Hubo un problema al compartir');
            }
        }
    }

    foreach ($params["txtPara"] as $id_usuario) {
        $cont = 0;
        $params["id_usuario_asignado"] = $id_usuario;
        $sql="SELECT ur.id_usuario, (SELECT CONCAT(emp.nombre,' ',emp.apellido) FROM empleado emp INNER JOIN usuario u ON u.id_empleado =emp.id_empleado  WHERE u.id_usuario = ur.id_usuario) AS nombre FROM usuario_repositorio ur WHERE ur.id_usuario=:id_usuario_asignado AND ur.id_repositorio=:txtId AND ur.estado = 'Activo'";
        $param_list = array("id_usuario_asignado","txtId");
        $response_validar = $data->query($sql, $params, $param_list);
        if ($response_validar["total"] == 0) {
            $sql="INSERT INTO usuario_repositorio (id_usuario, tipo, fecha_procesamiento, id_repositorio) VALUES (:id_usuario_asignado, 'Externo', NOW(), :txtId)";
            $param_list = array("id_usuario_asignado","txtId");
            $response = $data->query($sql, $params, $param_list, true);
            if ($response['insertId'] > 0) {
                $response=array('success'=>true, 'titulo'=>'Operación exitosa!', 'mensaje'=>'El repositorio ha sido compartido');
            }else{
                $response=array('success'=>false, 'titulo'=>'Verifique su información!', 'mensaje'=>'Hubo un problema al compartir');
            }
        } 
    }

}
echo json_encode($response);
?>