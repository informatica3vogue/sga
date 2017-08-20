<?php

@session_start();
include("../sql/class.managerDB.php");
include("../sql/class.data.php");
$data = new data();

$params = $_POST;

$params["txtDependencia"] = (isset($params["txtDependencia"])) ? $params["txtDependencia"] : $_SESSION["id_dependencia"];

$validar = 0;
foreach ($_SESSION['detalle_seccion'] as $campos) { if ($campos=="") { $validar++; } }

if ($validar > 0) {
	$response=array('success'=>false, 'titulo'=>'Verifique su información!', 'mensaje'=>'LLene correctamente los campos', 'tipo'=>'alert alert-info');
}else{
	if (isset($params["txtId"])) {
		$sql = "SELECT * FROM dependencia WHERE id_dependencia=:txtDependencia";
		$param_list = array("txtDependencia");
		$response = $data->query($sql, $params, $param_list);
		if ($response["total"] > 0) {
			$sql = "UPDATE seccion SET seccion=:txtSeccion, id_dependencia=:txtDependencia WHERE id_seccion=:txtId";
			$param_list = array("txtSeccion","txtId", "txtDependencia");
			$response = $data->query($sql, $params, $param_list, true);
		}else{
			$sql = "INSERT INTO dependencia (id_dependencia) VALUES (:txtDependencia)";
			$param_list = array("txtDependencia");
			$result = $data->query($sql, $params, $param_list, true);
			if ($result["success"] == true) {
				$sql = "UPDATE seccion SET seccion=:txtSeccion, id_dependencia=:txtDependencia WHERE id_seccion=:txtId";
				$param_list = array("txtSeccion","txtId", "txtDependencia");
				$response = $data->query($sql, $params, $param_list, true);
			}
		}
		if($response["success"] == true){
			$response=array('success'=>true, 'titulo'=>'Operacion exitosa!', 'mensaje'=>'Se ha modificado la seccion', 'tipo'=>'alert alert-success');
		}else{
		    $response=array('success'=>false, 'titulo'=>'Verifique su información!', 'mensaje'=>'No se modifico el registro', 'tipo'=>'alert alert-danger');
		}
	}else{
		$sql = "SELECT * FROM dependencia WHERE id_dependencia=:txtDependencia";
		$param_list = array("txtDependencia");
		$response = $data->query($sql, $params, $param_list);
		if ($response["total"] > 0) {
			foreach ($_SESSION['detalle_seccion'] as $seccion) {
				$params['secciones'] = $seccion['seccion'];
				$sql = "INSERT INTO seccion (seccion, id_dependencia) VALUES (:secciones, :txtDependencia)";
				$param_list = array("secciones", "txtDependencia");
				$response = $data->query($sql, $params, $param_list, true);
			}
		}else{
			$sql = "INSERT INTO dependencia (id_dependencia) VALUES (:txtDependencia)";
			$param_list = array("txtDependencia");
			$result = $data->query($sql, $params, $param_list, true);
			if ($result["success"] == true) {
				foreach ($_SESSION['detalle_seccion'] as $seccion2) {
					$params['secciones2'] = $seccion2['seccion'];
					$sql = "INSERT INTO seccion (seccion, id_dependencia) VALUES (:secciones2, :txtDependencia)";
					$param_list = array("secciones2", "txtDependencia");
					$response = $data->query($sql, $params, $param_list, true);
				}
			}
		}
		if($response["success"] == true){
				$response=array('success'=>true, 'titulo'=>'Operacion exitosa!', 'mensaje'=>'Se ha guardado el registro');
		}else{
				$response=array('success'=>false, 'titulo'=>'Verifique su información!', 'mensaje'=>'No se guardo el registro');
			}
	}
}
unset($_SESSION['detalle_seccion']);
echo json_encode($response);
?>