<?php 

@session_start();
include("../../sql/class.managerDB.php");
include("../../sql/class.data.php");

$data = new data();
$params = $_POST;
$params["id_usuario_bitacora"] = $_SESSION["id_usuario"];

$params["accion"] = 'cambio de estado, actividad: referencia: '.$params["txtrefActividad"].', \n estado: Pendiente';

if($params["txtEstadoFin"] != "Finalizado"){
    $sql = "UPDATE actividad SET estado = :txtEstadoFin, fecha_finalizacion = NULL WHERE id_actividad = :txtId_cestado";
    $param_list = array("txtEstadoFin","txtId_cestado");
    $response = $data->query($sql, $params, $param_list, true);
    if ($response['total'] > 0) {
        foreach ($params["txtAsignado"] as $asignado) {
            $params["id_usuario"] = intval($asignado);
            $sql = "INSERT INTO asignacion(fecha_asignacion, estado, id_usuario, id_actividad) VALUES (NOW(), 1, :id_usuario, :txtId_cestado)";
            $param_asignacion = array("id_usuario", "txtId_cestado");
            $result = $data->query($sql, $params, $param_asignacion, true);
        }
        $sql = "INSERT INTO bitacora(accion, tipo_accion, fecha_procesamiento, id_usuario) VALUES (:accion, 1, NOW(), :id_usuario_bitacora)";
        $param_bitacora = array("accion","id_usuario_bitacora");
        $response_bitacora = $data->query($sql, $params, $param_bitacora, true); 
    }
}

if ($response["total"] > 0 && $result["total"] > 0) {
    $response = array("success"=>true, 'titulo'=>'Operacion exitosa!', 'mensaje'=>'La actividad fue activada nuevamente');
} else {
    $response = array('success'=>false, 'titulo'=>'Verifique su informacion!', 'mensaje'=>'No se realizo el cambio');
}

echo json_encode($response);
?>