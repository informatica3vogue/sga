<?php
include("../../sql/class.data.php");

$params=$_POST;

$data= new data();
	$sql="UPDATE grupo SET grupo=:txtNombreGrupo WHERE id_grupo=:txtIdGrupo";
	$param_list = array("txtNombreGrupo","txtIdGrupo");
	$response = $data->query($sql, $params, $param_list);
	if($response['total'] > 0){
		$response=array('success'=>true, 'titulo'=>'Operacion exitosa!', 'mensaje'=>'Se ha modificado nombre del grupo');
	}else{
	    $response=array('success'=>false, 'titulo'=>'Verifique su información!', 'mensaje'=>'No se modifico el registro');
	}

echo json_encode($response);
?>