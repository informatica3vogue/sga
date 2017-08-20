<?php
@session_start();

include("../../sql/class.data.php");
$data= new data();

$params=$_POST;
$params["id_dependencia"] = $_SESSION["id_dependencia"];
if(isset($params["txtId"])){
	$sql="UPDATE articulo SET articulo=:txtArticulo, descripcion=:txtDescripcion,  id_marca=:txtMarcas, id_linea=:txtLineas, id_unidad=:txtUnidades WHERE id_articulo=:txtId";
	$param_list = array("txtArticulo","txtDescripcion","txtMarcas","txtLineas","txtUnidades","txtId");
	$response = $data->query($sql, $params, $param_list);
	if($response['total'] > 0){
		$response=array('success'=>true, 'titulo'=>'Operacion exitosa!', 'mensaje'=>'Se ha modificado el articulo');
	}else{
	    $response=array('success'=>false, 'titulo'=>'Verifique su información!', 'mensaje'=>'No se modifico el registro');
	}
}else{
	$sql="INSERT INTO articulo(articulo, descripcion, existencia, id_marca, id_linea, id_unidad, id_categoria, id_dependencia, fecha_procesamiento) VALUES (:txtArticulo, :txtDescripcion, 0, :txtMarcas, :txtLineas, :txtUnidades, 1, :id_dependencia, NOW())";
	$param_list=array("txtArticulo", "txtDescripcion", "txtMarcas", "txtLineas", "txtUnidades", "id_dependencia");
	$response=$data->query($sql, $params, $param_list, true);
	if ($response["insertId"] == 0) {
	   $response=array('success'=>false, 'titulo'=>'Verifique su información!', 'mensaje'=>'No se guardo el registro');
	}else{
		$response=array('success'=>true, 'titulo'=>'Operación exitosa!', 'mensaje'=>'Se agrego el artículo');
	}
}
echo json_encode($response);
?>