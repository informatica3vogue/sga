<?php

@session_start();
include("../sql/class.managerDB.php");
include("../sql/class.data.php");

$data = new data();
$params = $_POST;


    $params["id_usuario"] = $_SESSION["id_usuario"];
    $sql = "UPDATE usuario SET contrasenia=md5(:txtPassword) WHERE id_usuario=:id_usuario AND contrasenia=md5(:txtActual)";
    $param_list = array("txtPassword", "id_usuario", "txtActual");
    $response = $data->query($sql, $params, $param_list);
    if ($response["total"] > 0) {
        $response=array('success'=>true, 'titulo'=>'Operacion exitosa!', 'mensaje'=>'La contraseña ha sido modificada');
    }else{
        $response=array('success'=>false, 'titulo'=>'Verifique su información!', 'mensaje'=>'La contraseña no ha sido modificada');
    }
echo json_encode($response);
?>