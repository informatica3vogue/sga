<?php
@session_start();
include("../../sql/class.data.php");
include("../../php/fecha_servidor.php");
$data = new data();
$tipoCombo = array();

$params = $_POST;
$params["id_usuario"] = $_SESSION["id_usuario"];
$params["id_dependencia"] = $_SESSION["id_dependencia"];
$params["referencia"] = $data->generar_referencia_memo($_SESSION["abreviatura"], $params["id_dependencia"], $params["txtTipo"]);
$params["txtContenido"] = htmlspecialchars($params["txtContenido"]);
$params["txtDe"] = (isset($params["txtDe"])) ? $params["txtDe"] :  $_SESSION["nombre"].' / '.$_SESSION['cargo'];
$params["accion"] = 'se ha creado un memorandum, fecha creacion: '.date('d-m-y').', \n  tipo de memorandum: '.$params["txtTipo"].', \n con la referencia: '.$params["referencia"].'';

if (!empty($params["txtPara"])) {
    if (!empty($params["txtDe"])) {
        if ($params["txtTipo"] == "Interno") {
            $sql = "INSERT INTO memorandum (referencia, fecha_creacion, de, asunto, descripcion, con_copia, tipo_memorandum, id_dependencia, id_usuario) VALUES (:referencia, NOW(), :txtDe, :txtAsunto, :txtContenido, :txtCopia, :txtTipo, :id_dependencia, :id_usuario)";
            $param_list = array("referencia", "txtDe", "txtAsunto","txtContenido","txtCopia","txtTipo" ,"id_dependencia", "id_usuario");
            $response = $data->query($sql, $params, $param_list, true);
            $params["id_memorandum"] = $response["insertId"];
            foreach ($params["txtPara"] as $para) {
                 $params["tipo"] = end(explode('-', $para));
                    if($params["tipo"] == "empleado"){
                        $sql = "INSERT INTO memo_interno (id_empleado, id_memorandum) VALUES (:id_empleado, :id_memorandum)";
                        $params["id_empleado"] = $para;
                        $parametros = array("id_memorandum","id_empleado");
                        $response = $data->query($sql, $params, $parametros, true);
                    }else{
                        $params["id_grupo"]  = $para;
                        $sql2="SELECT id_empleado FROM grupo_empleado WHERE id_grupo=:id_grupo";
                        $param_list = array("id_grupo");
                        $response_empleado = $data->query($sql2, $params, $param_list);
                        foreach ($response_empleado['items'] as $id_empleados) {
                            $params["empleado"] = $id_empleados['id_empleado'];
                            $sql = "INSERT INTO memo_interno (id_empleado, id_memorandum) VALUES (:empleado, :id_memorandum)";
                            $parametros = array("empleado","id_memorandum");
                            $response = $data->query($sql, $params, $parametros, true);                           
                        }
                    }
            }
        }else{
            $sql = "INSERT INTO memorandum (referencia, fecha_creacion, de, para, asunto, descripcion, con_copia, tipo_memorandum, id_dependencia, id_usuario) VALUES (:referencia, NOW(), :txtDe, :txtPara, :txtAsunto, :txtContenido, :txtCopia, :txtTipo, :id_dependencia, :id_usuario)";
            $param_list = array("referencia", "txtDe", "txtPara", "txtAsunto","txtContenido","txtCopia","txtTipo", "id_dependencia", "id_usuario");
            $response = $data->query($sql, $params, $param_list, true);
            $params["id_memorandum"] = $response["insertId"];
        }
            if($response["insertId"]<>0){
                         $sql = "INSERT INTO bitacora(accion, tipo_accion, fecha_procesamiento, id_usuario) VALUES (:accion, 1, NOW(), :id_usuario)";
                         $param_bitacora = array("accion","id_usuario");
                         $response_bitacora = $data->query($sql, $params, $param_bitacora, true);
                     }

        if($response['insertId'] != 0){
            $response=array('success'=>true, 'titulo'=>'Operación exitosa', 'mensaje'=>'Se ha guardado el memorandum, Referencia N°: '.$params["referencia"], "id"=>$params["id_memorandum"]);
        }else{
            $response=array('success'=>false, 'titulo'=>'Verifique su información!', 'mensaje'=>'No se guardo el registro');
        }
    
    }else{
        $response=array('success'=>false, 'titulo'=>'Verifique su información!', 'mensaje'=>'El campo del emisor esta vacio');
    }

}else{
    $response=array('success'=>false, 'titulo'=>'Verifique su información!', 'mensaje'=>'El campo del receptor esta vacio');
}

echo json_encode($response);

?>