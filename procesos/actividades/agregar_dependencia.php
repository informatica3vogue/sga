<?php
@session_start();

include("../../sql/class.data.php");
$data= new data();

$params=$_POST;

$sql = "SELECT * FROM dependencia WHERE tipo = 2 AND dependencia=:txtNuevaDependencia";
$parametros = array("txtNuevaDependencia");
$result = $data->query($sql, $params, $parametros);
if ($result['total'] > 0) {
    $response = array('success'=>false, 'titulo'=>'Verifique su información!', 'mensaje'=>'Esta dependencia ya existe');
} else {
    $sql = "INSERT INTO dependencia (dependencia, tipo) VALUES (:txtNuevaDependencia, 2)";
    $param_list = array("txtNuevaDependencia");
    $response = $data->query($sql, $params, $param_list, true);
    if ($response['insertId'] == 0) {
       $response=array('success'=>false, 'titulo'=>'Verifique su información!', 'mensaje'=>'No se guardo el registro');
    }else{
        $response=array('success'=>true, 'titulo'=>'Operación exitosa!', 'mensaje'=>'Dependencia ingresada correctamente', 'id_dependencia'=>$response['insertId']);
    }
}
 
echo json_encode($response);
?>