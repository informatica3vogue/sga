<?php

@session_start();
include("../sql/class.managerDB.php");
include("../sql/class.data.php");
$data = new data();

$params = $_POST;
$validar = 0;
foreach ($params as $campos) { if ($campos=="") { $validar++; } }

if ($validar > 0) {
	$response=array('success'=>false, 'titulo'=>'Verifique su información!', 'mensaje'=>'LLene correctamente los campos', 'tipo'=>'alert alert-info');
}else{
	$sql = "SELECT * FROM dependencia WHERE id_dependencia=:txtDependencia";
	$param_list = array("txtDependencia");
	$response = $data->query($sql, $params, $param_list);
	if ($response["total"] > 0) {
		$sql = "UPDATE dependencia SET abreviatura=:txtAbreviatura WHERE id_dependencia=:txtDependencia";
		$param_list = array("txtAbreviatura", "txtDependencia");
		$response = $data->query($sql, $params, $param_list);
	}else{
		$sql = "INSERT INTO dependencia (id_dependencia, abreviatura) VALUES (:txtDependencia, :txtAbreviatura)";
		$param_list = array("txtDependencia", "txtAbreviatura");
		$response = $data->query($sql, $params, $param_list, true);
	}
	if($response["success"] == true){
		$response=array('success'=>true, 'titulo'=>'Operacion exitosa!', 'mensaje'=>'Se ha guardado el registro');
	}else{
		$response=array('success'=>false, 'titulo'=>'Verifique su información!', 'mensaje'=>'No se guardo el registro');
	}
}
echo json_encode($response);
?>