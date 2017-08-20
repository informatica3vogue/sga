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
$total_adjuntos = (!empty($_FILES['txtAdd2']['name'][0])) ? count($_FILES["txtAdd2"]["size"]): 0;

$params["accion"] = 'se agrego un nuevo seguimiento actividad con referencia: '.$params["txtReferencia"].', \n accion realizada: '.$params["txtAccion"].', \n archivos adjuntados: '.$total_adjuntos.', \n estado de la actividad: '.$params["txtEstado"].'.';
$params["txtAccion"] = preg_replace("/\r\n+|\r+|\n+|\t+/i", " ", $params['txtAccion']);

if(count($_FILES) > 0 && $_FILES['txtAdd2']['size'][0] > 0) {
    for ($i=0; $i <count($_FILES["txtAdd2"]["size"]) ; $i++) { 
        $name = $_FILES['txtAdd2']["name"][$i];
        $tmp_name = $_FILES['txtAdd2']['tmp_name'][$i];
        $envio = $data->upload($name, $tmp_name, $carpetaDestino);
        if($envio['success'] == true) {
            $adjuntos[] = $envio['file'];
        } else {
            $no_adjuntos[] = $envio['file'];
        }
    } 
    if (empty($no_adjuntos)) {
        $sql = "INSERT INTO seguimiento(accion_realizada, fecha_seguimiento, id_actividad, id_usuario)  VALUES (:txtAccion, NOW(), :txtId2, :id_usuario)";
        $param_list = array("txtAccion", "txtId2", "id_usuario");
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
            if($params["txtEstado"] != "Pendiente"){
                $param_finalizado = array("txtId2");
                $sql_actividad = "UPDATE actividad SET estado = 'Finalizado', fecha_finalizacion = NOW() WHERE id_actividad = :txtId2";
                $response = $data->query($sql_actividad, $params, $param_finalizado, true);
                $sql_asignacion = "UPDATE asignacion SET estado = 2, fecha_finalizacion = NOW() WHERE id_actividad = :txtId2";
                $response = $data->query($sql_asignacion, $params, $param_finalizado, true);
            }
            if ($response_adjunto["insertId"] <> 0) { 
                $sql = "INSERT INTO bitacora(accion, tipo_accion, fecha_procesamiento, id_usuario) VALUES (:accion, 1, NOW(), :id_usuario)";
                $param_bitacora = array("accion","id_usuario");
                $response_bitacora = $data->query($sql, $params, $param_bitacora, true); 
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
    $sql = "INSERT INTO seguimiento(accion_realizada, fecha_seguimiento, id_actividad, id_usuario)  VALUES (:txtAccion, NOW(), :txtId2, :id_usuario)";
    $param_list = array("txtAccion", "txtId2", "id_usuario");
    $response = $data->query($sql, $params, $param_list, true);
    if ($response["insertId"] <> 0) {
        if($params["txtEstado"] != "Pendiente"){
            $param_finalizado = array("txtId2");
            $sql_actividad = "UPDATE actividad SET estado = 'Finalizado', fecha_finalizacion = NOW() WHERE id_actividad = :txtId2";
            $response = $data->query($sql_actividad, $params, $param_finalizado, true);
            $sql_asignacion = "UPDATE asignacion SET estado = 2, fecha_finalizacion = NOW() WHERE id_actividad = :txtId2";
            $response = $data->query($sql_asignacion, $params, $param_finalizado, true);
        }
        $sql = "INSERT INTO bitacora(accion, tipo_accion, fecha_procesamiento, id_usuario) VALUES (:accion, 1, NOW(), :id_usuario)";
        $param_bitacora = array("accion","id_usuario");
        $response_bitacora = $data->query($sql, $params, $param_bitacora, true); 
        $response=array('success'=>true, 'mensaje'=>"Se ingreso el seguimiento correctamente");
    }
}
echo json_encode($response);
?>