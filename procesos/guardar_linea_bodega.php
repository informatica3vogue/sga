<?php
@session_start();

include("../sql/class.managerDB.php");
include("../sql/class.data.php");
$data= new data();

$params=$_POST;
$params["id_dependencia"] = $_SESSION["id_dependencia"];

$sql = "SELECT * FROM linea WHERE id_categoria = 2 AND linea=:txtLinea AND id_dependencia=:id_dependencia";
$parametros = array("txtLinea","id_dependencia");
$result = $data->query($sql, $params, $parametros);
if ($result['total'] > 0) {
    $response = array('success'=>false, 'titulo'=>'Verifique su información!', 'mensaje'=>'Esta linea ya existe');
} else {
	$sql="INSERT INTO linea (linea, id_dependencia, id_categoria) VALUES (:txtLinea, :id_dependencia, 2)";
	$param_list=array("txtLinea","id_dependencia");
	$response = $data->query($sql, $params, $param_list, true);
	if ($response['insertId'] == 0) {
	   $response=array('success'=>false, 'titulo'=>'Verifique su información!', 'mensaje'=>'No se guardo el registro');
	}else{
		$response=array('success'=>true, 'titulo'=>'Operación exitosa!', 'mensaje'=>'Se agrego linea', 'id_lineas'=>$response['insertId']);
	}
}
 
echo json_encode($response);
?>