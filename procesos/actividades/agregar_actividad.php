<?php
// proceso de ingreso de nueva actividad, llamado desde: ingreso_actividades_admin.php, 
@session_start();
include("../../sql/class.data.php");
include("../../php/fecha_servidor.php");

$data = new data();

$cont = 0;
$error_docs = "";
$params = $_POST;
$adjuntos = array();
$no_adjuntos = array();
$carpetaDestino="../../upload/actividades/";
$params["id_usuario"] = $_SESSION["id_usuario"];
$params["referencia"] = $data->generar_referencia_acti($_SESSION['abreviatura'], $_SESSION['id_dependencia']);

$total_adjuntos = (!empty($_FILES['txtAdd2']['name'][0])) ? count($_FILES["txtAdd2"]["size"]): 0;

$params["accion"] = 'se agrego nueva actividad: referencia: '.$params["referencia"].', \n referencia_origen: '.$params["txtReferencia"].', \n fecha_solicitud: '.date("d-m-Y", strtotime($params["txtFechaSolicitud"])).', \n solicitante: '.$params["txtSolicitante"].', \n requerimiento: '.$params["txtRequerimiento"].', \n fecha_procesamiento: '.$fecha.', \n marginado: '.$params["txtMarginado"].', \n con conocimiento: '.$params["txtConocimiento"].', \n dependencia solicitante: '.$data->nombre_dependencia($params["txtDependencia"]).', \n archivos adjuntados: '.$total_adjuntos.'';

$params["txtRequerimiento"] = preg_replace("/\r\n+|\r+|\n+|\t+/i", "<br>", $params['txtRequerimiento']);

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
        $sql = "INSERT INTO actividad(referencia, fecha_procesamiento, fecha_solicitud, id_dependencia_origen, solicitante, requerimiento, marginado, estado, referencia_origen, con_conocimiento, id_seccion, id_usuario_recepcion) VALUES (:referencia, NOW(), :txtFechaSolicitud, :txtDependencia, :txtSolicitante, :txtRequerimiento, :txtMarginado, 'Pendiente', :txtReferencia, :txtConocimiento, :txtSeccion, :id_usuario)";
        $param_list = array("referencia", "txtFechaSolicitud", "txtDependencia", "txtSolicitante", "txtRequerimiento", "txtMarginado", "txtReferencia", "txtConocimiento", "txtSeccion", "id_usuario");
        $response = $data->query($sql, $params, $param_list, true);
        if ($response["insertId"] <> 0) {
            $params["id_actividad"] = intval($response['insertId']);
            foreach ($adjuntos as $adjunto) {
                $params["adjunto"] = $adjunto;
                $params["extension"] = pathinfo($adjunto, PATHINFO_EXTENSION);
                $sql = "INSERT INTO docu_actividad(documento, tipo, id_actividad) VALUES (:adjunto, :extension, :id_actividad)";
                $param_list = array("adjunto","extension","id_actividad");
                $response_adjunto = $data->query($sql, $params, $param_list, true);
            }
            foreach ($params["txtAsignado"] as $asignado) {
                $params["id_usuario"] = intval($asignado);
                $sql = "INSERT INTO asignacion(fecha_asignacion, estado, id_usuario, id_actividad) VALUES (NOW(), 1, :id_usuario, :id_actividad)";
                $param_list = array("id_usuario", "id_actividad");
                $result = $data->query($sql, $params, $param_list, true);
            }
            if ($response_adjunto["insertId"] <> 0) { 
                $sql = "INSERT INTO bitacora(accion, tipo_accion, fecha_procesamiento, id_usuario) VALUES (:accion, 1, NOW(), :id_usuario)";
                $param_bitacora = array("accion","id_usuario");
                $response_bitacora = $data->query($sql, $params, $param_bitacora, true); 
            }
            if ($response["total"] > 0 &&  $result["total"] > 0) {
                $response = array('success'=>true, 'titulo'=>"Operacion exitosa!", 'mensaje'=>"Se ingresaron los datos correctamente", 'referencia'=> $params["referencia"]);
            }
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
    $sql = "INSERT INTO actividad(referencia, fecha_procesamiento, fecha_solicitud, id_dependencia_origen, solicitante, requerimiento, marginado, estado, referencia_origen, con_conocimiento, id_seccion, id_usuario_recepcion) VALUES (:referencia, NOW(), :txtFechaSolicitud, :txtDependencia, :txtSolicitante, :txtRequerimiento, :txtMarginado, 'Pendiente', :txtReferencia, :txtConocimiento, :txtSeccion, :id_usuario)";
    $param_list = array("referencia", "txtFechaSolicitud", "txtDependencia", "txtSolicitante", "txtRequerimiento", "txtMarginado", "txtReferencia", "txtConocimiento", "txtSeccion", "id_usuario");
    $response = $data->query($sql, $params, $param_list, true);
    if($response['insertId'] <> 0){
        $params["id_actividad"] = intval($response['insertId']);
        foreach ($params["txtAsignado"] as $asignado) {
            $params["id_usuario"] = intval($asignado);
            $sql = "INSERT INTO asignacion(fecha_asignacion, estado, id_usuario, id_actividad) VALUES (NOW(), 1, :id_usuario, :id_actividad)";
            $param_asignacion = array("id_usuario", "id_actividad");
            $result = $data->query($sql, $params, $param_asignacion, true);
        }
        $sql = "INSERT INTO bitacora(accion, tipo_accion, fecha_procesamiento, id_usuario) VALUES (:accion, 1, NOW(), :id_usuario)";
        $param_bitacora = array("accion","id_usuario");
        $response_bitacora = $data->query($sql, $params, $param_bitacora, true); 
    }
    if ($response["total"] > 0 &&  $result["total"] > 0) {
        $response = array('success'=>true, 'titulo'=>"Operacion exitosa!", 'mensaje'=>"Se ingresaron los datos correctamente", 'referencia'=>$params["referencia"]);
    }
}

echo json_encode($response);
?>