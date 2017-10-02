<?php
// proceso de almacenamiento de repositorio, llamado desde: repositorio.php
@session_start();
include("../../sql/class.data.php");

$data = new data();

$params = $_POST;
$adjuntos = array();
$no_adjuntos = array();
$error_docs = "";
$cont = 0;
$response = array();
$carpetaDestino="../../upload/repositorio/";
$params["id_usuario"] = $_SESSION["id_usuario"];
$params["id_dependencia"] = $_SESSION["id_dependencia"]; 
$params["txtPara"][] = $_SESSION["id_usuario"];
$total_adjuntos = (!empty($_FILES['txtArchivo']['name'][0])) ? count($_FILES["txtArchivo"]["name"]): 0;

$params["accion"] = 'se ingreso repositorio nuevo, fecha de creacion: '.date('d-m-Y').', \n titulo de repositorio: '.$params["txtAlias"].', \n observacion: '.$params["txtDescripcion"].', \n tipo de repositorio: '.$params["txtTipo"].'';

if($total_adjuntos > 0) {
    for ($i=0; $i <count($_FILES["txtArchivo"]["size"]) ; $i++) { 
        $name = $_FILES['txtArchivo']["name"][$i];
        $tmp_name = $_FILES['txtArchivo']['tmp_name'][$i];
        $envio = $data->upload($name, $tmp_name, $carpetaDestino);
        if($envio['success'] == true) {
            $adjuntos[] = $envio['file'];
        } else {
            $no_adjuntos[] = $envio['file'];
        }
    } 
    if (empty($no_adjuntos)) {
        $sql = "INSERT INTO repositorio(fecha_creacion, observacion, alias, tipo_repositorio, id_dependencia) VALUES (CURDATE(), :txtDescripcion, :txtAlias, :txtTipo, :id_dependencia)";
        $param_list = array("txtDescripcion", "txtAlias", "txtTipo", "id_dependencia");
        $response_repositorio = $data->query($sql, $params, $param_list, true);
        if ($response_repositorio["insertId"] > 0) {
            $params["id_repositorio"] = intval($response_repositorio['insertId']);
            foreach ($adjuntos as $adjunto) {
                $params["adjunto"] = $adjunto;
                $params["extension"] = pathinfo($adjunto, PATHINFO_EXTENSION);
                $sql = "INSERT INTO docu_repositorio(documento, tipo, id_repositorio) VALUES (:adjunto, :extension, :id_repositorio)";
                $param_list = array("adjunto","extension","id_repositorio");
                $response_adjunto = $data->query($sql, $params, $param_list, true);
            }
        }
        if ($params["txtTipo"] == "Privado") {
            $sql="INSERT INTO usuario_repositorio (estado, tipo, fecha_procesamiento, id_usuario, id_repositorio) VALUES ('Activo', 'Propietario', NOW(),  :id_usuario, :id_repositorio)";
            $param_list = array("id_usuario","id_repositorio" );
            $response_privado = $data->query($sql, $params, $param_list, true);
    
            if ($response_privado["insertId"] > 0) {
                $sql = "INSERT INTO bitacora(accion, tipo_accion, fecha_procesamiento, id_usuario) VALUES (:accion, 1, NOW(), :id_usuario)";
                $param_bitacora = array("accion","id_usuario");
                $response_bitacora = $data->query($sql, $params, $param_bitacora, true); 
                $response=array('success'=>true, 'titulo'=>'Operacion exitosa!', 'mensaje'=>'El repositorio ha sido guardado');
            }

        }else{           
            foreach ($params["txtPara"] as $asignado) {
                $params["usuario"] = intval($asignado);
                if ($params["usuario"] == $params["id_usuario"]) {
                    $sql="INSERT INTO usuario_repositorio (estado, tipo, fecha_procesamiento, id_usuario, id_repositorio) VALUES ('Activo',  'Propietario', NOW(),  :usuario, :id_repositorio)";
                    $param_list = array("usuario","id_repositorio");
                    $response_compartido = $data->query($sql, $params, $param_list, true);   
                }else{
                    $sql="INSERT INTO usuario_repositorio (estado, tipo, fecha_procesamiento, id_usuario, id_repositorio) VALUES ('Activo',  'Externo', NOW(),  :usuario, :id_repositorio)";
                    $param_list = array("usuario","id_repositorio");
                    $response_compartido = $data->query($sql, $params, $param_list, true);   
                }
            }
            if ($response_compartido["insertId"] > 0) {
                $sql = "INSERT INTO bitacora(accion, tipo_accion, fecha_procesamiento, id_usuario) VALUES (:accion, 1, NOW(), :id_usuario)";
                $param_bitacora = array("accion","id_usuario");
                $response_bitacora = $data->query($sql, $params, $param_bitacora, true); 
                $response=array('success'=>true, 'titulo'=>'Operacion exitosa!', 'mensaje'=>'El repositorio ha sido compartido');
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
}
echo json_encode($response);
?>