<?php
// proceso de almacenamiento de seguimiento, llamado desde: actividad.php
@session_start();
include("../../sql/class.data.php");

$data = new data();

$cont = 0;
$error_docs = "";
$params = $_POST;
$adjuntos = array();
$no_adjuntos = array();
$params["id_usuario"] = $_SESSION["id_usuario"];
$carpetaDestino="../../upload/actividades/";
$total_adjuntos = (!empty($_FILES['txtAdd']['name'][0])) ? count($_FILES["txtAdd"]["size"]): 0;

$params["accion"] = 'se agrego un nuevo seguimiento actividad con referencia: '.$params["txtReferencia_actividad"].', \n accion realizada: '.$params["txtSeguimiento"].', \n archivos adjuntados: '.$total_adjuntos.'.';
$params["txtSeguimiento"] = preg_replace("/\r\n+|\r+|\n+|\t+/i", " ", $params['txtSeguimiento']);
if(count($_FILES) > 0 && $_FILES['txtAdd']['size'][0] > 0) {
    for ($i=0; $i <count($_FILES["txtAdd"]["size"]) ; $i++) { 
        $name = $_FILES['txtAdd']["name"][$i];
        $tmp_name = $_FILES['txtAdd']['tmp_name'][$i];
        $envio = $data->upload($name, $tmp_name, $carpetaDestino);
        if($envio['success'] == true) {
            $adjuntos[] = $envio['file'];
        } else {
            $no_adjuntos[] = $envio['file'];
        }
    } 
    if (empty($no_adjuntos)) {
        $sql = "INSERT INTO seguimiento(accion_realizada, fecha_seguimiento, id_actividad, id_usuario)  VALUES (:txtSeguimiento, NOW(), :txtId6, :id_usuario)";
        $param_list = array("txtSeguimiento", "txtId6", "id_usuario");
        $response = $data->query($sql, $params, $param_list, true);
        if ($response["insertId"] <> 0) {
            $params["id_seguimiento"] = intval($response['insertId']);
            foreach ($adjuntos as $adjunto) {
                $params["adjunto"] = $adjunto;
                $params["extension"] = pathinfo($adjunto, PATHINFO_EXTENSION);
                $sql = "INSERT INTO docu_seguimiento(documento, tipo, id_seguimiento) VALUES (:adjunto, :extension, :id_seguimiento)";
                $param_list = array("adjunto","extension","id_seguimiento");
                $response_adjunto = $data->query($sql, $params, $param_list, true);
            }
            if ($response_adjunto["insertId"] <> 0) { 
                $sql = "INSERT INTO bitacora(accion, tipo_accion, fecha_procesamiento, id_usuario) VALUES (:accion, 1, NOW(), :id_usuario)";
                $param_bitacora = array("accion","id_usuario");
                $response_bitacora = $data->query($sql, $params, $param_bitacora, true); 
            }
            if ($params["txtAsignado"] <> $params["id_usuario"]) {
                $sql_finalizada = "UPDATE asignacion SET estado = 2, fecha_finalizacion = NOW() WHERE id_actividad = :txtId6 AND id_usuario = :id_usuario";
                $param_finalizada = array("txtId6", "id_usuario");
                $response_finalizada = $data->query($sql_finalizada, $params, $param_finalizada, true);
                if ($response_finalizada["success"] == true) {
                    $sql_asignacion = "INSERT INTO asignacion(fecha_asignacion, estado, id_usuario, id_actividad) VALUES (CURDATE(), 1, :txtAsignado, :txtId6)";
                    $param_asignacion = array("txtAsignado", "txtId6");
                    $response = $data->query($sql_asignacion, $params, $param_asignacion, true);
                }
            }
            $response=array('success'=>true, 'mensaje'=>"Se ingresaron los datos correctamente");
        }
    } else {
        foreach ($adjuntos as $adjunto) {
            $eliminar_adjunto = $destiny.$adjunto;
            @unlink($eliminar_adjunto);
        }
        $total = count($no_adjuntos);
        foreach ($no_adjuntos as $cadena){
            $cont ++;
            $error_docs .= ($cont == $total) ? $cadena : $cadena.', ';
        }
        $texto = (count($error_docs) > 1) ? 'los archivos' : 'el archivo';
        $response=array('success'=>false, 'mensaje'=>"Hubo un problema al subir ".$texto.": ".$error_docs);
    }
}else{
    $sql = "INSERT INTO seguimiento(accion_realizada, fecha_seguimiento, id_actividad, id_usuario)  VALUES (:txtSeguimiento, NOW(), :txtId6, :id_usuario)";
    $param_list = array("txtSeguimiento", "txtId6", "id_usuario");
    $response = $data->query($sql, $params, $param_list, true);
    if ($params["txtAsignado"] <> $params["id_usuario"]) {
        $sql_finalizada = "UPDATE asignacion SET estado = 2, fecha_finalizacion = NOW() WHERE id_actividad = :txtId6 AND id_usuario = :id_usuario";
        $param_finalizada = array("txtId6", "id_usuario");
        $response_finalizada = $data->query($sql_finalizada, $params, $param_finalizada, true);
        if ($response_finalizada["success"] == true) {
            $sql_asignacion = "INSERT INTO asignacion(fecha_asignacion, estado, id_usuario, id_actividad) VALUES (CURDATE(), 1, :txtAsignado, :txtId6)";
            $param_asignacion = array("txtAsignado", "txtId6");
            $response = $data->query($sql_asignacion, $params, $param_asignacion, true);
        }
    }
    if ($response["insertId"] <> 0) {
        $sql = "INSERT INTO bitacora(accion, tipo_accion, fecha_procesamiento, id_usuario) VALUES (:accion, 1, NOW(), :id_usuario)";
        $param_bitacora = array("accion","id_usuario");
        $response_bitacora = $data->query($sql, $params, $param_bitacora, true); 
        $response=array('success'=>true, 'mensaje'=>"Se ingreso el seguimiento correctamente");
    }
}
echo json_encode($response);
?>