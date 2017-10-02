<?php

@session_start();

include("../../sql/class.data.php");
$data = new data();

$cont = 0;
$error_docs = "";
$params = $_POST;
$adjuntos = array();
$no_adjuntos = array();
$carpetaDestino="../../upload/actividades/";
$params["id_usuario"] = $_SESSION["id_usuario"];

$sql = "UPDATE actividad SET fecha_solicitud = :txtFechaSolicitud, solicitante = :txtSolicitante, requerimiento = :txtRequerimiento, marginado = :txtMarginado, id_dependencia_origen = :txtDependencia, referencia_origen = :txtReferencia, con_conocimiento = :txtConocimiento WHERE id_actividad=:txtId";  
$param_list = array("txtFechaSolicitud", "txtSolicitante", "txtRequerimiento", "txtMarginado", "txtDependencia", "txtReferencia", "txtConocimiento", "txtId");
$response = $data->query($sql, $params, $param_list, true);

$sql = "UPDATE asignacion SET estado=2, fecha_finalizacion=NOW() WHERE id_actividad = :id_actividad AND estado = 1";
$response_inactivar = $data->query($sql, array('id_actividad'=>$params['txtId']), array(), true);

foreach ($params["txtAsignado"] as $nueva_asignacion) {
    $param_asignacion = array( 'id_actividad'=>$params['txtId'], 'id_usuario'=>$nueva_asignacion);
    $sql = "SELECT id_usuario FROM asignacion WHERE id_actividad = :id_actividad AND id_usuario= :id_usuario";
    $response_validar = $data->query($sql, $param_asignacion, array(), true);
    if($response_validar["total"] > 0){
        $sql = "SELECT MAX(a.id_asignacion) AS id_asignacion FROM asignacion AS a WHERE a.id_actividad = :id_actividad AND a.id_usuario = :id_usuario";
        $response_asignacion = $data->query($sql, $param_asignacion);
        if ($response_asignacion["total"] > 0) {
            $param_asignacion["id_asignacion"] = $response_asignacion["items"][0]["id_asignacion"];
            $sql = "UPDATE asignacion SET estado = 1, fecha_finalizacion = NULL WHERE id_actividad = :id_actividad AND id_usuario = :id_usuario AND id_asignacion = :id_asignacion";
            $response_validar = $data->query($sql, $param_asignacion, array(), true);
        }
    }else{
        $sql = "INSERT INTO asignacion (id_actividad,id_usuario,estado,fecha_asignacion) VALUES(:id_actividad,:id_usuario,1,NOW())";
        $response_validar = $data->query($sql, $param_asignacion, array(), true);
    }
}

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
        foreach ($adjuntos as $adjunto) {
            $params["adjunto"] = $adjunto;
            $params["extension"] = pathinfo($adjunto, PATHINFO_EXTENSION);
            $sql = "INSERT INTO docu_actividad(documento, tipo, id_actividad) VALUES (:adjunto, :extension, :txtId)";
            $param_list = array("adjunto","extension","txtId");
            $response_adjunto = $data->query($sql, $params, $param_list, true);
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
}

if ($response["success"] != false) {
   $response=array('success'=>true, 'titulo'=>"Operacion exitosa", 'mensaje'=>"La actividad se modifico correctamente"); 
}
echo json_encode($response);
?>